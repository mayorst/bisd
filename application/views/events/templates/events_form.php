<?php

    echo form_open('', 'class="container events-form"');
    echo form_fieldset();

    $title = isset($formValues['name']) ? "Update Event" : "Create Event";
?>
<h4><?=$title?></h4>
<div class="row">
<div class="col-md-12">
<?php
    form_input_wLabel('name', testVar($formValues['name']));
?>
</div>

<div class="col-md-4">
<?php
    $start_date = array(
        'label' => 'start_date',
        'input' => array(
            'type' => 'date',
            'value' => isset($formValues['start_date'])
            ? $formValues['start_date'] : date('Y-m-d'),
        ));
    form_input_wLabel($start_date);
    echo '</div><div class="col-md-2">';
    $start_time = array(
        'label' => 'start_time',
        'input' => array(
            'type' => 'time',
            'value' => isset($formValues['start_time'])
            ? $formValues['start_time'] : date('H:i'),
        ));
    form_input_wLabel($start_time);
?>
</div>
<div class="col-md-4">
<?php
    $end_date = array(
        'label' => 'end_date',
        'input' => array(
            'type' => 'date',
            'value' => isset($formValues['end_date'])
            ? $formValues['end_date'] : date('Y-m-d'),
        ));
    form_input_wLabel($end_date);
    echo '</div><div class="col-md-2">';
    $end_time = array(
        'label' => 'end_time',
        'input' => array(
            'type' => 'time',
            'value' => isset($formValues['end_time'])
            ? $formValues['end_time'] : date('H:i'),
        ));
    form_input_wLabel($end_time);
?>
</div>

<fieldset class="form-group address col-9">
    <div class="form-check row">
    	<label class="form-check-label">Venue:</label>
    	<?php
            $attr = array(
                'name' => 'addressChoice',
                'class' => 'form-check-input',
            );
            echo '<label class=" form-check-label">';
            echo form_radio($attr, 'venue', true,
                'onchange="showOneChild(\'#selectVenue\',\'.events-form #venue_address>div\')"');
            echo 'Seclect Venue';
            echo '</label><label class=" form-check-label">';
            echo form_radio($attr, 'custom',
                (testVar($formValues['addressChoice']) == 'custom') ? true : false,
                'onchange="showOneChild(\'#customAddress\',\'.events-form #venue_address>div\')"');
            echo 'Custom Venue';
            echo '</label>';

        ?>
    </div>
    <div id="venue_address">
    <div id="selectVenue" class="col-md-12">
    <?php
        $venues = isset($formValues['venueSelect'])
        ? $formValues['venueSelect'] : array();
        echo form_label('Select:', 'select_venue');
        echo form_dropdown('venue',
            $venues,
            '',
            'class="form-control col-md-12"  id="select_venue"');
    ?>

    </div>

    <div id="customAddress" class="col-md-12 hidden">
    <?php
        echo form_label('Address', 'id_addr');
        echo form_textarea(array('name' => 'address', 'rows' => '2', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_addr'),
            testVar($formValues['address']));
        echo form_inputFeedback('address');
    ?>
    </div>
    </div>
</fieldset>

<div class="col-md-3 ">
    <div class="vcenter">
    <label class="">Status: </label>
    <br>
<?php
    $attr = array(
        'name' => 'stat',
        'class' => 'form-check-input',
    );
    echo '<label class=" form-check-label">';
    echo form_radio($attr, 'active',
        (testVar($formValues['stat']) == 'cancelled') ? false : true);
    echo 'Active';
    echo '</label><label class=" form-check-label">';
    echo form_radio($attr, 'cancelled',
        (testVar($formValues['stat']) == 'cancelled') ? true : false);
    echo 'Cancelled';
    echo '</label>';
?>
</div>
</div>

<div class="col-12">
<?php
    echo form_label('Description', 'id_vdesc');
    echo form_textarea(
        array('name' => 'description', 'rows' => '4', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_vdesc'),
        testVar($formValues['description']));
    echo form_inputFeedback('description');
?>
 </div>
<div class="col-12 text-right mt-5">
<?php
    echo form_submit('', 'Set Event', 'class="btn btn-outline-primary"');
?>
</div>
</div>
<?php
    echo form_fieldset_close();
echo form_close();
