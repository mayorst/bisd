<?php 

include APPPATH.'config/config.php';


/************* PATHS ******************/

defined('PATH_HELPERS') OR define('PATH_HELPERS', APPPATH.'helpers/');


defined('PATH_CUSTOM_CONFIG') OR define('PATH_CUSTOM_CONFIG', APPPATH.'config/custom');
defined('PATH_PUBLIC') OR define('PATH_PUBLIC', $config['base_url'].'/public/');
defined('PATH_CSS') OR define('PATH_CSS', PATH_PUBLIC.'css/');
defined('PATH_JS') OR define('PATH_JS', PATH_PUBLIC.'js/');
defined('PATH_IMAGES') OR define('PATH_IMAGES', PATH_PUBLIC.'images/');
defined('PATH_ICONS') OR define('PATH_ICONS', PATH_IMAGES.'icons/');
defined('PATH_FONTS') OR define('PATH_FONTS', PATH_PUBLIC.'fonts/');



