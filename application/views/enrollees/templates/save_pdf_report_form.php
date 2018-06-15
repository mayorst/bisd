<div id="id_save_pdf" class="custom-modal">
    <div class="container">
	
<?php

echo form_open();

echo form_fieldset();

echo '<h3>Save PDF Report</h3>';

echo form_hidden('save_pdf_form');

$filename = "BISD_Enrollee_".date('Ymd_His');
form_input_wlabel('file_name',$filename);

echo '<div class="row">';
echo '<div class="form-group col-md-6">';
echo '<label>Paper Size:</label>';
$attr = ['id'=>'paper_size','name'=>'paper_size','class'=>'form-control'];
$options = ['Letter'=>'Letter','A4'=>'A4'];
echo form_dropdown($attr,$options);
echo form_inputFeedback($attr['name']);
echo '</div>';

echo '<div class="form-group col-md-6">';
echo '<label>Orientaion:</label>';
$attr = ['id'=>'orientation','name'=>'orientation','class'=>'form-control'];
$options = ['Portrait'=>'Portrait','Landscape'=>'Landscape'];
echo form_dropdown($attr,$options);
echo form_inputFeedback($attr['name']);
echo '</div>';
echo '</div>';

?>

<div class="align-right mt-3">
	<a class="custModal-cancel btn btn-outline-primary">Cancel</a>
	<?php
$form_submit = array(
    'class' => 'btn btn-outline-primary',
);
echo form_submit($form_submit, 'Save')?>
</div>

<?php
echo form_fieldset_close();
echo form_close();
?>
	</div>
</div>

