<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Course_model');
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
        template::landing('home');
    }

    public function courses()
    {
        $courses = array();
        $categs = $this->Course_model->getCategories('categ_id, categ_name');

        foreach ($categs as $key =>$value) {
            $categID = $value['categ_id'];
            $courseOfCategory = $this->Course_model->getCourses('', "category = $categID");
            $courses = $courses + array($value['categ_name'] => $courseOfCategory);
        }

        $data['courseList'] = $courses;
        template::landing('courses', $data);
    }

}
