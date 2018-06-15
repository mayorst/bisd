<?php 

/**
 * NOTES: 
 * $pdf - array pass by the controller
 * 
 */


// define("DOMPDF_ENABLE_REMOTE",true);

$dompdf = new Pdf();

$dompdf->load_html($pdf['content']);
$dompdf->set_paper(testVar($pdf['paper_size'],'Letter'),testVar($pdf['orientation'],'Portrait'));
$dompdf->render();

$dompdf->stream(testVar($pdf['file_name'],'SamplePDF'),array('Attachment'=>0));
