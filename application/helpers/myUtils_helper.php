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
