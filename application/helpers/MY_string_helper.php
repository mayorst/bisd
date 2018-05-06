<?php
/**
 * gets an a string or array to be formatted
 * @param  mixed $str [description]
 * @param  array $except -key/s to exclude in formatting if $str is an array
 * @param  boolean invert - if TRUE formats all the key in the $except
 * @return String      [description]
 */
function str_start_case($str = '', $except = array(), $invert = false)
{
    if (is_array($str)) {
        foreach ($str as $key => $value) {
            if ((!$invert) == in_array($key, $except)) {
                continue;
            }
            if (is_string($value)) {
                $str[$key] = str_start_case($value);
            }
        }
        return $str;
    }
    $str = str_replace('_', ' ', $str);
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

/**
 * converts string into html formatted paragraph.
 * @param  string $string_to_edit [description]
 * @return string                 [description]
 */
function newLine_to_pTag($string_to_edit)
{
    $string_to_edit = '<p>' . $string_to_edit . '</p>';
    // $string_to_edit = str_replace("\r\n\r\n", '</p><p>', $string_to_edit);
    //
    $string_to_edit = str_replace("\r\n", '</p><p>', $string_to_edit);
    return str_replace('<p></p>', '', $string_to_edit); // removes no value p tag
}

function str_path($str)
{
    return preg_replace('#/+#', '/', $str);
}
