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

/**
 * Overided method from CI_Upload.
 * I overide it to ignore the error if theres no file selected.
 * @param  string $open  [description]
 * @param  string $close [description]
 * @return [type]        [description]
 */
    public function display_errors($open = '', $close = '')
    {
        $error = parent::display_errors($open, $close);
        $error = trim(str_replace('You did not select a file to upload.', '', $error));
        return $error;
    }

}
