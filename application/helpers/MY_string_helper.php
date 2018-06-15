<?php
/**
 * gets a string or array to be formatted
 * @param  mixed $str [description]
 * @param  array $except -key/s to exclude in formatting if $str is an array
 * @param  boolean invert - if TRUE formats all the key in the $except
 * @return String      [description]
 */
function str_start_case($str = '', $except = array(), $invert = false)
{
    $currentArray = $str;
    if (is_array($str)) {
        foreach ($str as $key => $value) {
            if ((!$invert) == in_array($key, $except)) {
                continue;
            }
            if (is_string($value)) {
                $str[$key] = str_start_case($value);            }
        }

        // return array_merge($currentArray, $str);
        return $str;
    }
    $str = str_replace('_', ' ', $str);
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

/**
 * converts string Carriage Return into the tag specified in the argument
 * @param  [type] $string_to_edit [description]
 * @param  string $prefix         opening html tag
 * @param  string $suffix         closing html tag 
 * @return [type]                 [description]
 */
function carraigeReturn_to_tag($string_to_edit,$prefix='<p>', $suffix='</p>')
{
    $string_to_edit = $prefix . $string_to_edit . $suffix;
    $string_to_edit = str_replace("\r\n", $suffix.$prefix, $string_to_edit);
    return str_replace($prefix.$suffix, '', $string_to_edit); // removes no value  tag
}

function str_path($str)
{
    return preg_replace('#/+#', '/', $str);
}
