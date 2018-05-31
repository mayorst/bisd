<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Course_model');
        $this->load->model('Event_model');
        $this->load->model('PublicMessage_model');
        $this->load->model('Enrollee_model');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->home();
    }

    public function home()
    {

        $upcomEvents = $this->Event_model->getAll('', '', 5);
        $websiteMessage = $this->PublicMessage_model->getAll('', '');

        $data['upcomingEvents'] = $upcomEvents;
        $data['website_message'] = $websiteMessage;

        $data['page_title'] = "BISD - Home";
        $data['navbar_courseCategs'] = $this->get_courseCategs();
        template::landing('home', $data);
    }

    private function get_courseCategs()
    {
        return $this->Course_model->getCategories('categ_name');
    }

    public function courses()
    {
        $courses = array();
        $categs = $this->Course_model->getCategories('categ_id, categ_name');

        foreach ($categs as $key => $value)
        {
            $categID = $value['categ_id'];
            $courseOfCategory = $this->Course_model->getCourses('', "category = $categID");
            $courses = $courses + array($value['categ_name'] => $courseOfCategory);
        }

        $data['courseList'] = $courses;
        $data['navbar_courseCategs'] = $this->get_courseCategs();
        $data['page_title'] = "BISD - Course";

        template::landing('courses', $data);
    }

    public function course($courseID = '')
    {

        if ($_POST)
        {
            unset($_POST['submit']);
            $whListKey = array('first_name', 'middle_name', 'last_name', 'birthdate', 'gender', 'organization', 'occupation', 'phone_number', 'email', 'address1', 'address2', 'city', 'state', 'postal', 'country');

            if ($this->form_validation->run('enrollee_info'))
            {
                $cleanEnrollee = whList($_POST, $whListKey);
                if ($id = $this->Enrollee_model->createEnrollee($cleanEnrollee))
                {

                    $courseApplied = $_POST['courseApplied'];
                    foreach ($courseApplied as $key => $value)
                    {
                        $cols = array('enrollee_id' => $id, 'course_id' => $value);
                        $this->Enrollee_model->createAppliedCourse($cols);
                    }

                    prompt::success("Your request was successfully submitted.");
                    redirect('courses');
                }
            }

        }

        $courseID = $this->security->xss_clean($courseID);

        $data['course'] = $this->Course_model->getCourses('', "course_id = $courseID")[0];

        $data['preRequisite'] = $this->Course_model->getCourse_prereq('', $courseID);

        // get the foundation courses used in course form prerequisite chkbox
        if ($fcrs = $this->Course_model->getCourses("course_id", "categ_name = 'Foundation Courses' OR  categ_name = 'Foundation Course' "))
        {
            if (count($fcrs) > 0)
            {
                 $data['foundation_courses'] = array_kvp($fcrs, 0, 'course_id');
            }
        }

        $courses = array();
        $categs = $this->Course_model->getCategories('categ_id, categ_name');
        foreach ($categs as $key => $value)
        {
            $categID = $value['categ_id'];
            $courseOfCategory = $this->Course_model->getCourses('', "category = $categID");
            $courses = $courses + array($value['categ_name'] => $courseOfCategory);
        }
        $data['courseList'] = $courses;

        $data['page_title'] = "BISD - Course";
        $data['navbar_courseCategs'] = $this->get_courseCategs();
        template::landing('single_course', $data);
    }

    public function events()
    {
        $data['eventList'] = $this->Event_model->getAll();

        $data['page_title'] = "BISD - Events";
        $data['navbar_courseCategs'] = $this->get_courseCategs();
        template::landing('events', $data);
    }

}
