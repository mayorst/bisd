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

function generateRandomStr($length = 5){
    $str = 'absdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $shuffled = substr( str_shuffle( $str ), 0, $length);
    return $shuffled;
}