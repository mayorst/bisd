<?php

class Prompt
{

    protected $CI;
    private static $instance;
    private static $session;

    public function __construct()
    {
        $this->CI = &get_instance();
        self::$session = $this->CI->session;
    }

    public static function success($body = '', $title = 'Success')
    {
        self::$session->set_flashdata('log_success', array('title' => $title, 'body' => $body));
        // setting log-success triggers the view on th application/view/templates/prompt.php
    }

    public static function error($body = '', $title = 'Error')
    {
        self::$session->set_flashdata('log_error', array('title' => $title, 'body' => $body));
        // setting log-error triggers the view on th application/view/templates/prompt.php
    }
}

