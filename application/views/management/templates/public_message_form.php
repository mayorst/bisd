<?php
// $formValues - an array to store the values of the form inputs.

echo form_open();
echo form_hidden('publicMessage_form');

echo form_fieldset();

form_input_wLabel("title");

echo form_label('Addresser', 'id_txtFrom');
echo form_textarea(array('name' => 'from_', 'rows' => '3', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_txtFrom'), testVar($formValues['from'])
);
echo form_inputFeedback('from');

echo form_label('Message', 'id_txtMess');
echo form_textarea(array('name' => 'message', 'rows' => '15', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_txtMess'), testVar($formValues['message'])
);
echo form_inputFeedback('message');

echo '<div class="align-right mt-3">';
$attr = array('class' => 'btn btn-outline-primary');
echo form_submit($attr, 'Publish');
echo '</div>';

echo form_fieldset_close();
echo form_close();