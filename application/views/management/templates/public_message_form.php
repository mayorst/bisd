<?php
// $formValues - an array to store the values of the form inputs.

echo form_open();
echo form_hidden('publicMessage_form');

if (testVar($formValues['pmess_id']))
{
    echo form_hidden('pmess_id', $formValues['pmess_id']);
}

echo form_fieldset();

form_input_wLabel("title", testVar($formValues['title']));

echo '<div class="form-group">';
echo form_label('Addresser', 'id_txtFrom');
echo form_textarea(array('name' => 'from_', 'rows' => '3', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_txtFrom'), testVar($formValues['from_'])
);
echo form_inputFeedback('from_');
echo '</div>';

echo form_input_wLabel('external_link',testVar($formValues['external_link']));

echo form_label('Message', 'id_txtMess');
echo form_textarea(array('name' => 'message', 'rows' => '20', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_txtMess'), testVar($formValues['message'])
);
echo form_inputFeedback('message',testVar($formValues['external_link']));

echo '<div class="align-right mt-3">';
$attr = array('class' => 'btn btn-outline-primary');
echo form_submit($attr, 'Publish');
echo '</div>';

echo form_fieldset_close();
echo form_close();
