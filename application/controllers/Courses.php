<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * NOTES:
 * this class is not use because courses is controlled by Management/courses. When Im done i will refractor it to this Controller....
 *
 */
class Courses extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('home'); // redirect if not logged in
        }
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Course_model');
    }

    public function course($action = '', $id = '')
    {
        if ($_POST) {
            unset($_POST['submit']);
            $_POST = $this->security->xss_clean($_POST);

            if ($this->form_validation->run('course')) {
                $course = $_POST;
                $course['course_name'] = testVar($course['course_name']);

                if ($action == pv::CREATE) {
                    $categ = testVar($course['category']);
                    if (!empty($categ) && !is_numeric($categ)) {
                        $categID = $this->Course_model->createCategory(array('categ_name' => $categ));
                        $course['category'] = $categID;
                    }

                    $imgUp = imageUploader();
                    if ($imgUp->do_upload('img_path')) {
                        $course['img_path'] = $imgUp->db_img_path();
                    }

                    $prereq = $course['preReq']; // for adding pre req
                    unset($course['preReq']);

                    $whListKey = array(
                        'course_id', 'course_name', 'category', 'description', 'img_path', 'stat',
                    );
                    $newCourse = whList($course, $whListKey);

                    prd($newCourse);

                    if ($id = $this->Course_model->createCourse($course)) {

                        $img_error = $imgUp->display_errors(' ', ' ');
                        if ($img_error) {
                            prompt::error($img_error);
                        }

                        $this->Course_model->createPrereq($id, $prereq);
                        prompt::success('Course was successfully created.');
                        redirect(current_url());
                    }
                } else if ($action == pv::UPDATE) {
                    if (!empty($id)) {

                        $prereq = $course['preReq'];
                        $this->Course_model->createPrereq($id, $prereq);

                        unset($course['preReq']);

                        if ($this->Course_model->updateCourse($id, $course)) {
                            prompt::success('Course was successfully updated.');
                            redirect('management/course');
                        }
                    }

                }

            }
        }

        $data = array();

        if ($action) {
            $data['update'] = ($action == pv::UPDATE) ? true : false;

            $categories = $this->Course_model->getCategories('categ_id, categ_name');
            $data['categ'] = array_kvp($categories, 'categ_id', 'categ_name');
            $data['categ'] = $data['categ'] + array('new' => htmlspecialchars("<New Category>"));

            // used in prerequisite checkbox.
            $where = (testVar($id)) ? "course_id != $id" : '1=1';
            $courses = $this->Course_model->getCourses('', $where);
            $courses = array_kvp($courses, 'course_id', 'course_name');
            $data['courseList'] = $courses;

        } else {
            // viewCourseList for course viewing
            // creates an array of  array of courses with category name as key
            // used in course management

            $courses = array();
            $categs = $this->Course_model->getCategories('categ_id, categ_name');

            foreach ($categs as $key => $value) {
                $categID = $value['categ_id'];
                $courseOfCategory = $this->Course_model->getCourses('', "category = $categID");
                $courses = $courses + array($value['categ_name'] => $courseOfCategory);
            }

            $data['viewCourseList'] = $courses;
        }

        if (testVar($id, false)) {
            $data['courseToUpdate'] = $this->Course_model->getCourse($id);
            if (testVar($id)) {
                if ($pr = $this->Course_model->getCourse_prereq("course_id", $id)) {
                    $data['coursePrereq'] = array_kvp($pr, 0, 'course_id');
                }
                if ($pr = $this->Course_model->getCourse_prereq("req_by", $id, 'course_id')) {
                    if (count($pr) > 0) {
                        $data['requiredBy_course'] = array_kvp($pr, 0, 'req_by');
                    }
                }
            }
        }
        Template::management('courses', $data);
    }

}
