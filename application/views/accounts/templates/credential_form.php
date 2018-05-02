<?php
    /**
     * $view_setting:
     * inputOnly - diplays only the input tag. removes the form tag.
     * noConfirmPassword - removes the confirmPassword
     * withSubmit - displays submit buttons if the 'inputOnly' is set.
     *
     * $title - the Heading of the form
     * $buttons = assoc. array() - the key is the name of the button and values is the attribute
     * $btnSubmit = assoc array() - attribute of the submit button.
     * $form_action - url to submit form
     * $user_to_update - array of the information of a member
     * 
     */
    
    use \public_variables as pv;

    $userInfo = (isset($user_to_update))?$user_to_update: testVar($_SESSION['user']);

    $view_setting = isset($view_setting) ? (!is_array($view_setting) ? array($view_setting) : $view_setting) : array();
    $buttons = isset($buttons) ? $buttons : array('submit');

    if (!in_array('inputOnly', $view_setting)) {
        echo form_open(testVar($form_action), array('class' => 'userCredential'));
    }
    echo form_fieldset();
?>
    <h4>
    <?php echo isset($title) ? $title : 'Account'; // overite the $data['title'] on the calling environment to remove $title
    ?>
    </h4>
    <?php
    if ($type === pv::UPDATE){
        echo form_hidden('credentials_form');
    }?>
    <?php form_input_wLabel(array('label' => 'username'),(($type === pv::UPDATE)? $userInfo['username']:''));?>
    <?php form_input_wLabel(array('label' => '_password', 'input' => array('type' => 'password')));?>
    <?php if (!in_array('noConfirmPassword', $view_setting)) {?>
    <?php form_input_wLabel(array('label' => 'Confirm Password', 'input' => array('type' => 'password')));?>
    <?php }?>
    <?php
    if (!in_array('inputOnly', $view_setting) || in_array('withSubmit', $view_setting)) {
        echo '<div class="form-group align-right">';

        foreach ($buttons as $key => $value) {

            $name = 'noName';
            $btnClass = 'btn btn-outline-success right-button';
            $attr = 'class="' . $btnClass . '" ';
            if (is_array($value)) {
                $name = $key;
                $currClass = isset($value['class']) ? $value['class'] : '';
                $value['class'] = $btnClass . ' ' . $currClass;
                $attr = $value;
            } else {
                $name = $value;
            }

            echo '<a ' . _attributes_to_string($attr) . '> ' . str_start_case($name) . '</a>';
        }

        $name = 'noName';
        $btnClass = 'btn btn-outline-success right-button';
        $attr = 'class="' . $btnClass . '" ';

        echo form_submit(testVar($btnSubmit, 'submit'),
            str_start_case($btnSubmit, 'submit'),
            $attr);

        echo '</div>';}

    echo form_fieldset_close();

    if (!in_array('inputOnly', $view_setting)) {
        echo form_close();}

?>