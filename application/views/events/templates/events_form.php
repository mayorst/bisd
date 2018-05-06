<?php

    echo form_open('', 'class="container"');
    echo form_fieldset();
?>
<div class="row">
<div class="col-md-12">
<?php
    form_input_wLabel('name');
?>
</div>

<div class="col-md-6">
<?php
    $start_date = array(
        'label' => 'time_start',
        'input' => array('type' => 'date'));
    form_input_wLabel($start_date);
?>
</div>
<div class="col-md-6">
<?php
    $end_date = array(
        'label' => 'time_end',
        'input' => array('type' => 'date'));
    form_input_wLabel($end_date);
?>
</div>

<div class="col-md-5">
<?php
    echo form_label('Address', 'id_addr');
    echo form_textarea(array('name' => 'address', 'rows' => '2', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_addr'), testVar($formUpdate['address']));
    echo form_inputFeedback('address');
?>
</div>
<p class="col-md-2 text-center ">OR</p>
<div class="col-md-5">
<?php
    $venues = array('venue1', 'venue2', 'venue3');
    echo form_label('Venue', 'select_venue');
    echo form_dropdown('venue',
        $venues,
        '',
        'class="form-control"  id="select_venue"');
?>
 </div>
 <div class="col-12">
<?php
    echo form_label('Description', 'id_vdesc');
    echo form_textarea(array('name' => 'description', 'rows' => '4', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_vdesc'), testVar($formUpdate['description']));
    echo form_inputFeedback('description');
?>
 </div>
<div class="col-12 text-right">
<?php
    echo form_submit('', 'Set Event', 'class="btn btn-outline-primary"');
?>
</div>
</div>
<?php
    echo form_fieldset_close();
echo form_close();
