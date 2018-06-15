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
    if (is_array($array))
    {
        $result = array();
        foreach ($array as $indexArray)
        {

            if (is_numeric($columnKey))
            {
                $key = $columnKey++;
            }
            else
            {
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
function imageUploader($dir = 'uploads/img/', $customConfig = '')
{
    $CI = &get_instance();

    $config['upload_path'] = resrc_dir($dir);
    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['encrypt_name'] = true;
    $config['max_filename'] = 200;
    $config['file_ext_tolower'] = true;
    $config['max_size'] = 4096;
    $config['max_width'] = 10000;
    $config['max_height'] = 10000;

    if (!empty($customConfig))
    {
        $config = array_merge($config, $customConfig);
    }
    createFolder_wIndex($config['upload_path']);

    $CI->load->library('upload');
    $CI->upload->initialize($config, true);
    return $CI->upload;
}

/**
 * Whitelist the keys on the inputed array
 * @param  [type] $array   [description]
 * @param  array  $keyList [description]
 * @return [type]          [description]
 */
function whList($array, $keyList = array())
{
    $whiteListed = array();
    if (!empty($keyList))
    {
        if (is_array($keyList))
        {
            foreach ($array as $key => $value)
            {
                if (in_array($key, $keyList))
                {
                    $whiteListed[$key] = $value;
                }
            }
        }
    }
    else
    {
        return $array;
    }
    return $whiteListed;
}

/**
 * get the file relative to  the resrc path. returns the default image if the file not exist.
 * @param  [type] $path [description]
 * @return [type]       [description]
 */
function get_resc($path)
{
    $path = RESRC_PATH . $path;
    if (!file_exists($path) || is_dir($path))
    {
        return IMG_DEF;
    }
    return str_replace(RESRC_PATH, RESRC, $path);
}

/**
 * compress an image
 * @param  [type] $source      [description]
 * @param  [type] $destination [description]
 * @param  [type] $quality     integer, 0-100
 * @return [type]              [description]
 */
function img_compress($source, $destination, $quality)
{

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
    {
        $image = imagecreatefromjpeg($source);
    }
    elseif ($info['mime'] == 'image/gif')
    {
        $image = imagecreatefromgif($source);
    }
    elseif ($info['mime'] == 'image/png')
    {
        $image = imagecreatefrompng($source);
        imageAlphaBlending($image, true);
        imageSaveAlpha($image, true);

        $quality = (int) ($quality * 0.1);
        imagePng($image, $destination, $quality);
        return;
    }

    imagejpeg($image, $destination, $quality);

    return $destination;
}


function get_local_dir($path=''){
    if(empty($path)){
        return '';
    }
    return str_replace(base_url(),FCPATH,$path);
}

function get_data_URI($image,$mime){
    return 'data:'.(function_exists('mime_content_type')?mime_content_type($image):$mime).';base64,'.base64_encode(file_get_contents($image));
}

/**
 * test if the input is a link. create if not. adds and http: or https: in the string
 * @param  string $link [description]
 * @return [type]       [description]
 */
function getLink($link = '#')
    {
        if ($link != '#')
        {
            $result = in_array(preg_match('#https?://#', $link), [0, false]);

            if ($result)
            {
                $link = 'http://' . $link;
            }
        }
        return $link;
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

    if (is_dir($path))
    {
        if ($p = increment_subfolder($path, $subfolderLimit))
        {
            return $p;
        }
    }
    else
    {
        if (!file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        if ($p = increment_subfolder($path, $subfolderLimit))
        {
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
    if (is_dir($path))
    {
        $subfolder = glob(str_path($path . '/*'), GLOB_ONLYDIR);

        $lastDir = '1';
        if (count($subfolder) > 0)
        {
            foreach ($subfolder as $key => $value)
            {
                $val = str_replace($path, '', $value);
                $subfolder[$key] = str_replace('/', '', $val);
            }
            sort($subfolder, SORT_NUMERIC);
            $lastDir = $subfolder[count($subfolder) - 1];

            $lastPath = glob(str_path($path . '/' . $lastDir . '/*'));

            if (count($lastPath) < $limit)
            {
                return str_path($path . '/' . $lastDir);
            }
            else
            {
                $nextFolder = intval($lastDir);
                $p1 = str_path($path . '/' . ++$nextFolder);
                if (!file_exists($p1))
                {
                    createFolder_wIndex($p1);
                }
                return $p1;
            }

        }
        else
        {
            $subPath = str_path($path . '/1/');
            if (!file_exists($subPath))
            {
                createFolder_wIndex($subPath);
            }
            return $subPath;
        }
    }
    else
    {
        return false;
    }
}

/**
 * creates a new folder if not exist with an index file.
 * @param  string $path [description]
 * @return [type]       [description]
 */
function createFolder_wIndex($path = '')
{
    if (!file_exists($path))
    {
        mkdir($path, 0777, true);
    }
    $pathParts = explode('/', $path);
    $nextPath = '';
    foreach ($pathParts as $key => $value)
    {
        $nextPath .= $value . '/';
        if (file_exists($nextPath . 'index.html'))
        {
            continue;
        }

        create404page($nextPath);
    }
}

function create404page($filepath = '')
{
    if (!empty($filepath) && is_dir($filepath))
    {
        $file404 = fopen($filepath . "/index.html", "w") or die("Unable to open file!");

        $txt = '<!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="utf-8">
            <title>404 Page Not Found</title>
            <style type="text/css">

            ::selection { background-color: #E13300; color: white; }
            ::-moz-selection { background-color: #E13300; color: white; }

            body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
            }

            code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
            }

            #container {
                margin: 10px;
                border: 1px solid #D0D0D0;
                box-shadow: 0 0 8px #D0D0D0;
            }

            p {
                margin: 12px 15px 12px 15px;
            }
            </style>
            </head>
            <body>
                <div id="container">
                    <h1>HTTP 404: Page not Found</h1>
                    <div>
                    <p>
                        We cant find the page you are accessing.
                    </p>
                    </div>
                </div>
            </body>
            </html>';

        fwrite($file404, $txt);
        fclose($file404);
    }
}
