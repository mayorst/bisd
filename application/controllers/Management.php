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

                $whListKey = array(
                    'course_id', 'course_name', 'category', 'description', 'course_schedule', 'tuition_fee',
                    'img_path', 'stat',
                );

                if ($action == pv::CREATE)
                {
                    $categ = testVar($course['category']);
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
                        $foundation_course = strpos($categ, 'Foundation Courses');
                        $foundation_course1 = strpos($categ, 'Foundation Course');
                        if (($foundation_course or $foundation_course1) != false)
                        {
                            $prereq = array();
                        }
                        else
                        {
                            $prereq = testVar($course['preReq']); // for adding pre req

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

    public function article($action = '')
    {
        $action = $this->security->xss_clean($action);

        if (strtolower($action) == 'update')
        {
            $websiteMessage = $this->PublicMessage_model->getAll('', '', 1)[0];
            $data['formValues'] = $websiteMessage;

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
                $this->updateMessage($_POST);
            }

        }
    }
    public function updateMessage($POST)
    {
        if ($this->form_validation->run('publicMessage'))
        {
            $id = $POST['pmess_id'];
            $whiteList = array('title', 'from_', 'message');
            $POST = whList($POST, $whiteList);
            $POST['date_publish'] = date('Y-m-d');

            if ($this->PublicMessage_model->update($id, $POST))
            {
                prompt::success("You've successfully update your Article.");
                redirect('management/dashboard');
            }
            else
            {
                prompt::error("An error occur when saving your message. Please try again.");
            }

        }
    }

    public function index()
    {
        redirect('management/dashboard', 'refresh');
    }
};
