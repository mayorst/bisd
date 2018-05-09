<?php

include APPPATH . 'config/config.php';

/************* PATHS ******************/

defined('PATH_HELPERS') or define('PATH_HELPERS', APPPATH . 'helpers/');

defined('PATH_CUSTOM_CONFIG') or define('PATH_CUSTOM_CONFIG', APPPATH . 'config/custom');
defined('PATH_PUBLIC') or define('PATH_PUBLIC', $config['base_url'] . 'public/');
defined('PATH_CSS') or define('PATH_CSS', PATH_PUBLIC . 'css/');
defined('PATH_JS') or define('PATH_JS', PATH_PUBLIC . 'js/');
defined('PATH_IMAGES') or define('PATH_IMAGES', PATH_PUBLIC . 'images/');
defined('PATH_ICONS') or define('PATH_ICONS', PATH_IMAGES . 'icons/');
defined('PATH_FONTS') or define('PATH_FONTS', PATH_PUBLIC . 'fonts/');

defined('RESRC') or define('RESRC', $config['base_url'] . 'resrc/');
defined('RESRC_PATH') or define('RESRC_PATH', FCPATH . 'resrc/');
defined('IMG_DEF') or define('IMG_DEF', PATH_IMAGES . 'img-def.jpg');
