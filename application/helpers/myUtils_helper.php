<?php
/**
 * Test the variable if set or not.
 * @param  [type] &$var       [description]
 * @param  [type] $defaultVal [description]
 * @return [type]             returns the variable value if existing NULL otherwise.
 */
function testVar(&$var, $defaultVal = null)
{
    return isset($var) ? $var : $defaultVal;
}

/**
 * Result_array to key/value pair
 * make a key value pair using the result array from thr database
 *
 * @param  array $array       [description]
 * @param  String $columnKey   if numeric, the will key also be numeric
 * @param  String $columnValue [description]
 * @return Array              [description]
 */
function array_kvp($array, $columnKey, $columnValue)
{
    if (is_array($array)) {
        $result = array();
        foreach ($array as $indexArray) {

            if (is_numeric($columnKey)) {
                $key = $columnKey++;
            } else {
                $key = $indexArray[$columnKey];
            }

            $result[$key] = $indexArray[$columnValue];
        }
        return $result;
    }
    return false;
}

function sendEmail($to, $subject = 'Test', $message = 'Testing Email.')
{
    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "465");

    $CI = &get_instance();
    $CI->load->library('email');

    $confing = array(
        'protocol' => 'smtp',
        'smtp_host' => "smtp.gmail.com",
        'smtp_port' => 465,
        'smtp_user' => "dev.mayorst@gmail.com",
        'smtp_pass' => "mayorDev0502",
        'smtp_crypto' => 'ssl',
        'mailtype' => 'html',
    );
    $CI->email->initialize($confing);
    $CI->email->set_newline("\r\n");
    $CI->email->from('dev.mayorst@gmail.com', 'Benitez Institute for Sustainable Development');
    $CI->email->to($to);
    $CI->email->subject($subject);
    $CI->email->message($message);

    return $CI->email->send();

}

/**
 * returns and instance of the upload library
 * @return File_Uploader class
 */
function imageUploader($dir = 'uploads/img/')
{
    $CI = &get_instance();

    $config['upload_path'] = resrc_dir($dir);
    $config['allowed_types'] = 'gif|jpg|png';
    $config['encrypt_name'] = true;
    $config['max_filename'] = 200;
    $config['file_ext_tolower'] = true;
    $config['max_size'] = 4096;
    $config['max_width'] = 2000;
    $config['max_height'] = 1080;

    $CI->load->library('upload');
    $CI->upload->initialize($config, true);
    return $CI->upload;
}

/*======= ======== ======== ========= =========*/

function generateRandomStr($length = 1)
{
    $str = 'absdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $shuffled = substr(str_shuffle($str), 0, $length);
    return $shuffled;
}
/**
 * check and create a directory relative to the resource directory
 * @param  string $path [description]
 * @return string        the path to create
 */
function resrc_dir($path, $subfolderLimit = 2000)
{

    $path = FCPATH . str_path('resrc/' . $path);

    if (is_dir($path)) {
        if ($p = increment_subfolder($path, $subfolderLimit)) {
            return $p;
        }
    } else {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($p = increment_subfolder($path, $subfolderLimit)) {
            return $p;
        }
    }
}

/**
 * createa s new folder is certain limit of file is achieved.
 * @param  [type]  $path  [description]
 * @param  integer $limit [description]
 * @return string      [description]
 */
function increment_subfolder($path, $limit = 1000)
{
    if (is_dir($path)) {
        $subfolder = glob(str_path($path . '/*'), GLOB_ONLYDIR);

        // print_r($subfolder);die();
        $lastDir = '1';
        if (count($subfolder) > 0) {
            foreach ($subfolder as $key => $value) {
                $val = str_replace($path, '', $value);
                $subfolder[$key] = str_replace('/', '', $val);
            }
            sort($subfolder, SORT_NUMERIC);
            $lastDir = $subfolder[count($subfolder) - 1];

            $lastPath = glob(str_path($path . '/' . $lastDir . '/*'));

            if (count($lastPath) < $limit) {
                return str_path($path . '/' . $lastDir);
            } else {
                $nextFolder = intval($lastDir);
                $p1 = str_path($path . '/' . ++$nextFolder);
                if (!file_exists($p1)) {
                    mkdir($p1, 0777, true);
                }
                return $p1;
            }

        } else {
            $subPath = str_path($path . '/1/');
            if (!file_exists($subPath)) {
                mkdir($subPath, 0777, true);
            }
            return $subPath;
        }
    } else {
        return false;
    }
}
