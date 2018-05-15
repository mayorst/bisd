<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * NOTES:
 *  - if ($this->form_validation->run('login') == false) { .... // the rules was set on application/config/form_validation.php, and run('login') called that validation.
 * - form_helper is loaded by form_validation
 */

use \public_variables as pv;

class Accounts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            // Allow some methods?
            $allowed = array(
                'login', 'verify', 'forgotPassword',
            );
            if (!in_array($this->router->fetch_method(), $allowed)) {
                redirect('login');
            }

        }

        $this->load->library('form_validation');
        $this->load->model('Account_model');

        $this->load->library('table');

    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {

        if ($this->isLoggedIn()) {
            redirect(base_url() . 'management', 'refresh');
        }

        if ($_POST) {

            if ($this->form_validation->run('login') == false) {
                // the rules was set on application/config/form_validation.php, and run('login') called that validation.
                Template::accounts('login');

            } else {
                $data = $this->security->xss_clean($_POST);          
                $user = $this->Account_model->checkUser($data);

                if ($user) {
                    $this->session->set_userdata('user', $user);
                    $this->session->set_userdata('logged_in', true);
                    redirect(base_url("management"), 'refresh');
                } else {
                    prompt::error('Sorry, the Username or Password doesn\'t match to any account.', "Invalid Username or Password");
                    Template::accounts('login');
                }
            }
        } else {
            Template::accounts('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('home'), 'refresh');
    }

    public function isLoggedIn()
    {
        if (!empty($this->session->userdata('logged_in'))) {
            return true;
        } else {
            return false;
        }
    }

    public function is_admin()
    {
        return $_SESSION['user']['_position'] === public_variables::ACCOUNT_POSITION['admin'];
    }

    public function view()
    {
        Template::accounts('view_account');
    }

    public function manage()
    {
        $this->table->set_template(pv::UI_TABLE_TEMPLATE);
        $this->table->set_heading(array('Member ID', 'Name', 'Username', 'Birthdate', 'Contact Number', 'Email', 'Position', 'Status', 'Update'));
        $query = $this->Account_model->getAll();

        if ($query) {
            $ctr = 0;
            foreach ($query as $rowArray) {
                if (is_array($rowArray)) {
                    $btn = anchor("accounts/update/" . $rowArray['member_id'], "Update", "class='btn btn-primary'");
                    $addedColumn = array('btnUpdate' => $btn);
                    $rowArray = array_merge($rowArray, $addedColumn);
                    $query[$ctr] = $rowArray;
                    $ctr++;
                }
            }
        }

        $data['tblMember'] = $this->table->generate($query);

        Template::accounts('manage_account', $data);
    }

/**
 * function called by the form validation in the config/form_validation.php used to check unique username
 * @return bool - TRUE if usename is unique
 */
    public function check_username($username)
    {
        if ($this->isLoggedIn()) {
            $usernameHolder = (testVar($this->user_to_update)) 
                ? $this->user_to_update : 
                $_SESSION['user']['member_id'];

            if ($this->Account_model->isUsernameUnique($username, $usernameHolder)) {
                return true;
            } else {
                $this->form_validation->set_message('check_username', 'The Username was already taken.');
                return false;
            }
        }

    }

    public function create()
    {
        if ($this->isLoggedIn()) {
            if ($this->is_admin()) {
                if ($_POST) {
                    $_POST = $this->security->xss_clean($_POST);          
                    $this->form_validation->load_config_rule('memberInfo_all');
                    $this->form_validation->set_rules(
                        'email', 'Email',
                        array(
                            'trim', 'required',
                            array('isEmailUnique', array($this->Account_model, 'isEmailUnique')),
                        )
                    );
                    $this->form_validation->set_message('isEmailUnique', 'The Email was already used by another account. Add new Email Address.');

                    if ($this->form_validation->run('memberInfo_all') == false) {

                        Template::accounts('create_account');
                    } else {
                        $newMember = $_POST;
                        if ($newMember['confirm_password'] || $newMember['create_account']) {
                            unset($newMember['confirm_password'],
                                $newMember['create_account']);
                        }

                        if ($newMember['_password']) {
                            $newMember['_password'] = password_hash($newMember['_password'], PASSWORD_DEFAULT);
                        }

                        $newMember = str_start_case($newMember, array('email', 'username', '_password', 'prof_pic'));

                        // $newMember['member_id'] = $this->Account_model->getNextUserID();
                        // $newMember['_status'] = pv::ACCOUNT_STATUS['active'];
                        // $result = $this->Account_model->addMember($newMember); // if isesave naagad sa db

                        $verificationKey = md5(uniqid());
                        $newMember['acc_verification'] = $verificationKey;
                        $newMember['_status'] = 'unregistered';

                        if ($id = $this->Account_model->addTempMember($newMember)) {
                            if ($id) {
                                $subject = "Account Verification";
                                $message = 'This is to verify your account at Benitez Institute for Sustainable Development Website. Please click the link or copy and paste it to the url to verify your account. \n\n\n ' .
                                base_url("accounts/verify/$id/" . $verificationKey);

                                if (!sendEmail($newMember['email'], $subject, $message)) {
                                    $this->Account_model->deleteTempMember($id);

                                    prompt::error('An error occured while sending email. The Account was not created. ');
                                    redirect(base_url('accounts/manage'), 'refresh');
                                } else {
                                    prompt::success('The Account was created. Please check ' . $newMember['email'] . ' to verify the account.');
                                    redirect(base_url('accounts/manage'), 'refresh');
                                }
                            }

                        } else {
                            prompt::error('Unable to create acount.Please Try again.');
                        }

                    }
                } else {
                    Template::accounts('create_account');
                }
            } else {
                Prompt::error("Only Admin has access to create Account.");
                redirect(base_url('management'), 'refresh');
            }

        } else {
            Template::accounts('login');
        }
    }

    public function verify($id, $key)
    {
        if (!empty($id) && !empty($key)) {
            if ($user = $this->Account_model->getTempUser('', 'temp_member_id = ' . $id . ' AND acc_verification = \'' . $key . '\'')) {
                unset($user['temp_member_id'], $user['acc_verification']);

                $user['member_id'] = $this->Account_model->getNextUserID();
                $user['_status'] = 'Active';

                if ($this->Account_model->addMember($user)) {
                    $this->Account_model->deleteTempMember($id);
                    redirect('login', 'refresh');
                }
            }
        }
    }

    public function isEmailUnique($email, $id = '')
    {
        if ($this->Account_model->isEmailUnique($email, $id)) {
            return true;
        } else {

            $this->form_validation->set_message('isEmailUnique', 'The Email was already used by another account. Add new Email Address.');
            return false;
        }
    }
    public $user_to_update = '';
    public function update($user_id = '')
    {
        $this->user_to_update = $user_id;
        if ($this->isLoggedIn()) {
            if ($this->is_admin()
                || $_SESSION['user']['member_id'] == $user_id) {

                if ($_POST) {
                    $updatedInfo  = $this->security->xss_clean($_POST);          ;
                    unset($updatedInfo['confirm_password'], $updatedInfo['update']);
                    //hash the password
                    if (isset($updatedInfo['_password'])) {
                        $updatedInfo['_password'] = password_hash($updatedInfo['_password'], PASSWORD_DEFAULT);
                    }

                    $runUpdate = false;
                    if (isset($_POST['credentials_form'])) {

                        unset($updatedInfo['credentials_form']);

                        if ($this->form_validation->run('update_credentials')) {

                            if (!empty($_POST['old_password'])) {
                                $oldPass = $updatedInfo['old_password'];
                                $oldUser = $this->Account_model->getUser($user_id);

                                $pass = password_verify($oldPass, testVar($oldUser['_password']));

                                if ($pass) {
                                    unset($updatedInfo['old_password']);
                                    $runUpdate = true;
                                } else {
                                    prompt::error('Invalid old password.');
                                }
                            } else {
                                // if  no old pass, just update username.
                                unset($updatedInfo['old_password'], $updatedInfo['_password']);
                                if (!empty($_POST['_password'])) {
                                    prompt::error("Please enter your old password.");
                                    // redirect(current_url());
                                } else {
                                    $runUpdate = true;
                                }

                            }

                        }

                    } else {
                        $this->form_validation->load_config_rule('memberInfo');
                        $this->form_validation->set_rules(
                            'email', 'Email',
                            array(
                                'trim', 'required',
                                'callback_isEmailUnique['
                                . $user_id . ']',
                            )
                        );

                        if ($this->form_validation->run('memberInfo')) {
                            $runUpdate = true;
                        }
                    }
                    if ($runUpdate) {
                        $userId = testVar($user_id, $_SESSION['user']['member_id']);
                        $updatedInfo = str_start_case($updatedInfo, array('email', 'username', '_password', 'prof_pic'));
                        $result = $this->Account_model->updateMember($userId, $updatedInfo);

                        if ($result) {
                            if ($user_id === $_SESSION['user']['member_id']) {
                                $user = $this->Account_model->getUser($userId);
                                if ($user) {
                                    $this->session->set_userdata('user', $user);
                                }
                            }
                            prompt::success('Your account Information was saved.', 'Successfully Updated');

                            if ($this->is_admin()) {
                                redirect(base_url('accounts/manage'), 'refresh');
                            } else {
                                redirect(base_url('management'), 'refresh');
                            }
                        }
                    }

                }
                $data['user_to_update'] = $this->Account_model->getUser($user_id);
                Template::accounts('update_account', $data);

            } else {
                Prompt::error("You can only update your own Account.");
                redirect(base_url('management'), 'refresh');
            }

        } else {
            Template::accounts('login');
        }
    }

    public function forgotPassword()
    {

        if ($_POST) {
            // if ($this->form_validation->run('credentials')) {
            $_POST  = $this->security->xss_clean($_POST);          
            $usern = $_POST['username'];

            if ($acc = $this->Account_model->getMember('', "username = '" . $usern . "' OR email = '".$usern."'")) {
                $id = $acc['member_id'];
                $pass = generateRandomStr(6);
                $acc['_password'] = password_hash($pass, PASSWORD_DEFAULT);

                $subject = "Change Password";
                $mess = "Your account at BISD website was change. Your new password is : " . $pass;

                if (sendEmail($acc['email'], $subject, $mess)) {

                    if ($this->Account_model->updateMember($id, $acc)) {
                        prompt::success('Your account password was change. Your new Password is sent to ' . $acc['email'] . '.');
                        redirect('login');
                    } else {
                        prompt::error("Unable to change your password.");
                    }

                } else {
                    prompt::error("Unable to send new password to your email.");
                }

            } else {
                prompt::error("Username doesn't match to any account.");
            }
            // }
        }

        Template::accounts('forgot_password');
    }

}
