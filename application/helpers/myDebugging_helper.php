<?php

function alert($msg = '')
{
    if (isset($msg)) {
        $msg = htmlspecialchars($msg);
        //  filter_var($msg,FILTER_SANITIZE_SPECIAL_CHARS);

    }
    echo "<script type='text/javascript'>alert(\"$msg\");</script>";

}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

/**
 * exit system and print a variable
 * used in debugging
 * @param  [type] &$var [description]
 * @return [type]       [description]
 */
function prd($var = null)
{
    die(print_r($var));
}
