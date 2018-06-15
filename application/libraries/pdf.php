<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once dirname(__FILE__) . '/dompdf/dompdf_config.inc.php';
require_once dirname(__FILE__) . '/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
    function __construct()
    {
        parent::__construct();
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */