<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function load_page($view, $vars=array(), $output = false){

    // $CI = &get_instance();
    // return $CI->load->view($view, $vars, $output);
}

/** generating url for directing to a view or controller.
@returns string
NOTE: I set the .htaccess in the root directory that is why the index.php is omitted in the url
*/
function gotoURL($url=''){
	return base_url($url);
}




