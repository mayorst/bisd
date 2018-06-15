<?php defined('BASEPATH') or exit('No direct script access allowed');

use \public_variables as pv;

class Management extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in'))
        {
            redirect('home');
        }

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Course_model');
        $this->load->model('PublicMessage_model');
    }

    public function course($action = '', $id = '')
    {
        $action = $this->security->xss_clean($action);
        $id = $this->security->xss_clean($id);

        if ($_POST)
        {
            unset($_POST['submit']);
            $_POST = $this->security->xss_clean($_POST);

            if ($this->form_validation->run('course'))
            {
                $course = $_POST;
                $course['course_name'] = testVar($course['course_name']);
                $categ = testVar($course['category']);

                $whListKey = array(
                    'course_id', 'course_name', 'course_abbr', 'category', 'description', 'course_schedule', 'tuition_fee',
                    'img_path', 'stat',
                );

                if ($action == pv::CREATE)
                {
                    if (!empty($categ) && !is_numeric($categ))
                    {
                        $categID = $this->Course_model->createCategory(array(
                            'categ_name' => $categ));
                        $course['category'] = $categID;
                    }

                    $imgUp = imageUploader();
                    if ($imgUp->do_upload('img_path'))
                    {
                        $course['img_path'] = $imgUp->db_img_path();
                    }

                    $foundation_course = strpos($categ, 'Foundation Courses');
                    $foundation_course1 = strpos($categ, 'Foundation Course');
                    if (($foundation_course or $foundation_course1) != false)
                    {
                        $prereq = array();
                        unset($course['preReq']);
                    }
                    else
                    {
                        $prereq = testVar($course['preReq']); // for adding pre req
                        unset($course['preReq']);
                    }

                    $newCourse = whList($course, $whListKey);

                    if ($id = $this->Course_model->createCourse($newCourse))
                    {
                        $img_error = $imgUp->display_errors(' ', ' ');
                        if ($img_error)
                        {
                            prompt::error($img_error);
                        }

                        $this->Course_model->createPrereq($id, $prereq);
                        prompt::success('Course was successfully created.');
                        redirect(current_url());
                    }
                }
                else if ($action == pv::UPDATE)
                {
                    if (!empty($id))
                    {
                        $categ = $this->Course_model->getCategories('categ_name',"categ_id = '".$categ."'")[0]['categ_name'];
                        $foundation_course = strpos(strtolower($categ), strtolower('Foundation'));

                        if ($foundation_course === false )
                        {
                            $prereq = testVar($course['preReq']); // for adding pre req
                        }
                        else
                        {
                            $prereq = array();
                        }
                        unset($course['preReq']);

                        $this->Course_model->createPrereq($id, $prereq);

                        $imgUp = imageUploader();
                        if ($imgUp->do_upload('img_path'))
                        {
                            $course['img_path'] = $imgUp->db_img_path();
                        }

                        $uptCourse = whList($course, $whListKey);

                        if ($this->Course_model->updateCourse($id, $uptCourse))
                        {
                            $img_error = $imgUp->display_errors(' ', ' ');
                            if ($img_error)
                            {
                                prompt::error($img_error);
                            }

                            prompt::success('Course was successfully updated.')
                            ;
                            redirect('management/course');
                        }
                    }

                }

            }
        }

        $data = array();

        if ($action)
        {
            $data['update'] = ($action == pv::UPDATE) ? true : false;

            $categories = $this->Course_model->getCategories(
                'categ_id, categ_name');
            $data['categ'] = array_kvp($categories, 'categ_id', 'categ_name');
            $data['categ'] = $data['categ'] + array('new' => htmlspecialchars(
                "<New Category>"));

            // used in prerequisite checkbox.
            $where = (testVar($id)) ? "course_id != $id" : '1=1';
            $courses = $this->Course_model->getCourses('', $where);
            $courses = array_kvp($courses, 'course_id', 'course_name');
            $data['courseList'] = $courses;

        }
        else
        {
            // viewCourseList for course viewing
            // creates an array of  array of courses with category name as key
            // used in course management

            $courses = array();
            $categs = $this->Course_model->getCategories('categ_id, categ_name'
            );

            foreach ($categs as $key => $value)
            {
                $categID = $value['categ_id'];
                $courseOfCategory = $this->Course_model->getCourses('', "
                                                         category = $categID");
                $courses = $courses + array($value['categ_name'] =>
                    $courseOfCategory);
            }

            $data['viewCourseList'] = $courses;
        }

        if (testVar($id, false))
        {
            $data['courseToUpdate'] = $this->Course_model->getCourse($id);
            if (testVar($id))
            {
                if ($pr = $this->Course_model->getCourse_prereq("course_id",
                    $id))
                {
                    $data['coursePrereq'] = array_kvp($pr, 0, 'course_id');
                }
                if ($pr = $this->Course_model->getCourse_prereq("req_by", $id,
                    'course_id'))
                {
                    if (count($pr) > 0)
                    {
                        $data['requiredBy_course'] = array_kvp($pr, 0, 'req_by'
                        );
                    }
                }

                // get the foundation courses used in course form prerequisite chkbox
                if ($fcrs = $this->Course_model->getCourses("course_id", "categ_name = 'Foundation Courses' OR  categ_name = 'Foundation Course' "))
                {
                    if (count($fcrs) > 0)
                    {
                        $data['foundation_courses'] = array_kvp($fcrs, 0, 'course_id'
                        );
                    }
                }

                //test if image exists
                $course = $data['courseToUpdate'];
                if (!file_exists(RESRC_PATH . $course['img_path']))
                {
                    $data['courseToUpdate']['img_path'] = '';
                }
            }
        }
        $data['page_title'] = "BISD - Manage Courses";
        Template::management('courses', $data);
    }

    public function dashboard()
    {
        if ($_POST)
        {
            $_POST = $this->security->xss_clean($_POST);

            if (isset($_POST['logo_form']))
            {
                $this->changeLogo($_POST);
            }
        }

        $websiteMessage = $this->PublicMessage_model->getAll('', '', 1)[0];
        $data['website_message'] = $websiteMessage;

        if( $links =  read_file(pv::EXTERNAL_LINKS_JSON)){
            $data['extLinks'] = json_decode($links,True);
        }

        $data['page_title'] = "BISD - Management";
        Template::management('dashboard', $data);
    }

    public function changeLogo($POST)
    {
        $config['upload_path'] = FCPATH . 'public/images/icons/';
        $config['file_name'] = 'bisd_logo.png';
        $config['encrypt_name'] = false;
        $config['overwrite'] = true;
        $imgUp = imageUploader('', $config);

        if ($imgUp->do_upload('img_path'))
        {
            sleep(0.5);
            prompt::success("The Website Logo was Successfully Change.");
            redirect('management/dashboard', 'refresh');
        }
        else
        {
            $error = $imgUp->display_errors();
            if ($error)
            {
                prompt::error($error);
            }
        }
    }

    public function article($action = '',$id='')
    {
        $action = $this->security->xss_clean($action);
        $id = $this->security->xss_clean($id);

        if (strtolower($action) == 'create')
        {

            $articleList = $this->PublicMessage_model->getAll('', '', 20);
            $data['articleList'] = $articleList;
            $data['articleAction'] = "Create Article:";

            $data['page_title'] = "BISD - Create Article";
            Template::management('update_article', $data);
        }
        else if (strtolower($action) == 'update')
        {

            $where = "pmess_id = '".$id."'";
            $websiteMessage = $this->PublicMessage_model->getAll('', $where, 1)[0];
            $data['formValues'] = $websiteMessage;

            $articleList = $this->PublicMessage_model->getAll('', '', 20);
            $data['articleList'] = $articleList;
            $data['articleAction'] = "Update Article:";

            $data['page_title'] = "BISD - Update Article";
            Template::management('update_article', $data);
        }
        else
        {
            redirect('management/dashboard');
        }

        if ($_POST)
        {
            $_POST = $this->security->xss_clean($_POST);

            if (isset($_POST['logo_form']))
            {
                $this->changeLogo($_POST);
            }
            else if (isset($_POST['publicMessage_form']))
            {

                $whiteList = array('pmess_id','title', 'from_', 'message', 'external_link');
                $_POST = whList($_POST, $whiteList);

                if (strtolower($action) == 'create')
                {
                    $this->createMessage($_POST);
                }
                else if (strtolower($action) == 'update')
                {
                    $this->updateMessage($_POST);
                }
            }

        }
    }

    private function createMessage($POST)
    {
        if ($this->form_validation->run('publicMessage'))
        {
            $id = $POST['pmess_id'];

            $POST['external_link'] = getLink($POST['external_link']);
            $POST['date_publish'] = date('Y-m-d');

            if ($this->PublicMessage_model->create($POST))
            {
                prompt::success("You've successfully created your Article.");
                redirect('management/dashboard');
            }
            else
            {
                prompt::error("An error occur when saving your message. Please try again.");
            }

        }
    }
    public function updateMessage($POST)
    {
        if ($this->form_validation->run('publicMessage'))
        {
            $id = $POST['pmess_id'];

            $POST['external_link'] = getLink($POST['external_link']);
            $POST['date_publish'] = date('Y-m-d');

            if ($this->PublicMessage_model->update($id, $POST))
            {
                prompt::success("You've successfully updated your Article.");
                redirect('management/dashboard');
            }
            else
            {
                prompt::error("An error occur when saving your message. Please try again.");
            }

        }
    }

   public function saveExternalLink(){
        if($_POST){
            $_POST = $this->security->xss_clean($_POST);

            $wh_list = ['fb_link','twitter_link'];
            $_POST = whList($_POST,$wh_list);

            $_POST['fb_link'] = getLink($_POST['fb_link']);
            $_POST['twitter_link'] = getLink($_POST['twitter_link']);

            if(!is_dir(FILES_PATH)){
                createFolder_wIndex(FILES_PATH);
            }

            if(write_file(pv::EXTERNAL_LINKS_JSON ,json_encode($_POST))){
                prompt::success("The external Links was successfully saved.");
            }else{
                prompt::error("There was an error on saving the links. Try again Later.");
            }

            $this->index();
        }
   }

    public function index()
    {
        redirect('management/dashboard', 'refresh');
    }
};
