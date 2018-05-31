<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Template
{

    protected static $CI;
    private static $instance;
    private static $load;

    public function __construct()
    {
        self::$CI = &get_instance();
        self::$load = self::$CI->load;
    }

    // public static function getInstance()
    // {
    //     if (is_null(self::$instance)) {
    //         self::$instance = new Template();
    //     }
    //     return self::$instance;
    // }

    public static function landing($page = 'home', $data = array())
    {
        $pagePath = 'landing/' . $page . '.php';
        if (!file_exists(VIEWPATH . $pagePath)) {
            show_404();
        }
        if (!isset($data['config'])) {
            $data['config'] = self::$CI->config->config;
        }
        
        


        self::$load->view('templates/header', $data);
        self::$load->view('templates/navbar', $data);
        self::$load->view($pagePath, $data);
        self::$load->view('templates/footer', $data);
    }

    public static function accounts($page = 'login', $data = array())
    {
        $pagePath = 'accounts/' . $page . '.php';
        if (!file_exists(VIEWPATH . $pagePath)) {
            show_404();
        }
        if (!isset($data['config'])) {
            $data['config'] = self::$CI->config->config;
        }

        self::$load->view('templates/header', $data);

        $defNavPage = array('login', 'forgot_password');
        if (in_array($page, $defNavPage)) {
            self::$load->view('templates/navbar', $data);
        } else {
            self::$load->view('templates/mngmnt_navbar', $data);
        }

        self::$load->view('templates/prompt', $data);

        self::$load->view($pagePath, $data);
        self::$load->view('templates/footer', $data);
    }

    public static function management($page = 'dashboard', $data = array())
    {
        $pagePath = 'management/' . $page . '.php';
        if (!file_exists(VIEWPATH . $pagePath)) {
            show_404();
        }
        if (!isset($data['config'])) {
            $data['config'] = self::$CI->config->config;
        }
        self::$load->view('templates/header', $data);
        self::$load->view('templates/mngmnt_navbar', $data);

        self::$load->view('templates/prompt', $data);

        self::$load->view($pagePath, $data);
        self::$load->view('templates/mngmnt_footer', $data);

    }

    public static function events($page = 'view_events', $data = array())
    {
        $pagePath = 'events/' . $page . '.php';
        if (!file_exists(VIEWPATH . $pagePath)) {
            show_404();
        }
        if (!isset($data['config'])) {
            $data['config'] = self::$CI->config->config;
        }
        self::$load->view('templates/header', $data);
        self::$load->view('templates/mngmnt_navbar', $data);

        self::$load->view('templates/prompt', $data);

        self::$load->view($pagePath, $data);
        self::$load->view('templates/mngmnt_footer', $data);
    }

}
