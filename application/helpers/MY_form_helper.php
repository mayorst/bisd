<?php
$CI = &get_instance();
$CI->load->helper('string');

/**
 * creates a form input with label and error feedback
 * NOTE:
 * passed $data(array) must have a key named 'input' if you want to overwrite the default value of form_input.
 * @param  mixed  $data  [description]
 * @param  string $value [description]
 * @param  mixed $extra [description]
 */
function form_input_wLabel($data = '', $value = '', $extra = '')
{

    $form_input_attr = array();

    if (is_array($data)) {
        $label = isset($data['label']) ? $data['label'] : 'noLabel';
        if (isset($data['input']) && is_array($data['input'])) {
            $form_input_attr = $data['input'];
        }
    } else {
        $label = $data;
        $data = array('label' => $data);
    }

    $defaults = array(
        'id' => 'id_' . strtolower(str_replace(' ', '_', $label)),
    );
    $data['input'] = array_merge($defaults, $form_input_attr);

    echo '<div class="form-group">';
    $label = str_start_case($label);
    $lblStr = isset($data['lblIcon']) ? $data['lblIcon'] . " $label" : $label;
    echo form_label($lblStr, $data['input']['id']);
    form_input_wErrorNotif($data, $value, $extra);
    echo '</div>';
}

/**
 * creates a form input with error feedback. $data['feedbackClass'], set the class of the feedback
 *
 * @param  array  $data  [description]
 * @param  string $value [description]
 * @param  string $extra [description]
 * @return String        [description]
 */
function form_input_wErrorNotif($data = array(), $value = '', $extra = '')
{
    $label = 'noName';
    $form_input_attr = array();

    if (is_array($data)) {
        $label =
        isset($data['label']) ? $data['label'] : (
            isset($data['name']) ? $data['name'] : 'noName');
    } else {
        $label = $data;
    }

    $defaults = array(
        'name' => str_replace(' ', '_', strtolower($label)),
        'id' => 'id_' . strtolower(str_replace(' ', '_', $label)),
        'class' => "form-control",
        'aria-describedby' => str_start_case($label),
        // 'placeholder' => str_start_case($label),
        'value' => set_value(strtolower($label), $value),
    );

    $form_input_attr =
    (isset($data['input']) and is_array($data['input']))
    ? array_merge($defaults, $data['input'])
    : (is_array($data) ? array_merge($defaults, $data) : $defaults);

    echo form_input($form_input_attr, $value, $extra);

    if (isset($form_input_attr['name'])) {
        echo form_inputFeedback($form_input_attr['name'], $data);
    }
}

function form_inputFeedback($form_input_name, $data = '')
{
    $feedbackClass = '';
    if (isset($data['feedbackClass'])) {
        $feedbackClass = $data['feedbackClass'];
    }
    return form_error($form_input_name, '<div class="invalid-feedback ' . $feedbackClass . '">', '</div>');

}
