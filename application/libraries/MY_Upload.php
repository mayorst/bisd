<?php

class MY_Upload extends CI_Upload
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    public function db_img_path()
    {
        $save_path = $this->upload_path . $this->file_name;
        $find = 'resrc/';
        $path_start = strpos($save_path, $find) + strlen($find);

        return substr($save_path, $path_start);
    }

}
