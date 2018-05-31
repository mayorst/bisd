<?php

/**
 * NOTES:
 * $preRequisite was defined in the script who called this file.
 * 
 */

echo form_open('', 'class = "course-inquiry-form form-undecorated"');
echo form_fieldset();

echo '<h4 class="mb-3">Sign-up for a BISD Course</h4>';

?><div class="row"><?php
echo '<div class="col-sm-5">';
	form_input_wLabel('first_name');

echo '</div><div class="col-sm-2">';
	$attr = array(
	    'label' => "M.I.",
	    'input' => array(
	        'name' => 'middle_name',
	    ),
	);
	form_input_wLabel($attr);

echo '</div><div class="col-sm-5">';
	form_input_wLabel('last_name');

echo '</div><div class="col-sm-6">';
	$d = date('Y-m-d');
	$date = strtotime($d . ' -18 year');
	$date = date('Y-m-d', $date);

	$attr = array(
		'label' => 'Birthdate',
		'input' => array(
			'type' => 'date',
			'value' => $date,
			),
	);
	form_input_wLabel($attr);
echo '</div><div class="col-sm-6">';
 	form_input_wLabel('gender');
 	
	// gender as radio button
	// echo "<label>Gender</label>";
	// 
	// $attrMale = array(
	// 		'type' => 'radio',
	// 		'class' => 'form-check-input',
	// 		'name' => 'gender',
	// 		'value' => 'male',
	// 		'checked' => 'checked',
	// );
	// $attrFemale = array(
	// 		'type' => 'radio',
	// 		'class' => 'form-check-input',
	// 		'name' => 'gender',
	// 		'value' => 'female',
	// );

	// echo '<div class="col-12 row ">';
	// echo '<div class="col-6">';
	// echo '<label class="form-check-label vcenter-tbl-parent">'.form_radio($attrMale).' <span class="vcenter-tbl">&nbsp Male</span></label>';
	// echo '</div><div class="col-6">';
	// echo '<label class="form-check-label vcenter-tbl-parent">'.form_radio($attrFemale).' <span class="vcenter-tbl">&nbspFemale</span></label>';
	// echo '</div></div>';

echo '</div><div class="col-sm-8">';
	$attr = array(
	    'label' => "School/Organization",
	    'input' => array('name'=>"organization"),
	);
	form_input_wLabel($attr);

echo '</div><div class="col-sm-4">';
	form_input_wLabel('occupation');

echo '</div><div class="col-sm-6">';
	form_input_wLabel('phone_number');

echo '</div><div class="col-sm-6">';
$attr = array(
    'label' => "Email",
    'input' => array(
        'name' => 'email',
        'type' => 'email',
    ),
);
form_input_wLabel($attr);
echo '</div>';

echo '<div class="inquirer-address col-12 row">';
	echo '<div class="col-sm-12">';
	echo '<label>Address</label>';

	echo '</div><div class="col-sm-12">';
	form_input_wErrorNotif(
		array('name' => 'address1','placeholder' => 'Address Line 1'));
	echo '</div><div class="col-sm-12">';
	form_input_wErrorNotif(
		array('name' => 'address2','placeholder' => 'Address Line 2'));
	echo '</div><div class="col-sm-6">';
	form_input_wErrorNotif(
		array('name' => 'city','placeholder' => 'City'));
	echo '</div><div class="col-sm-6">';
	form_input_wErrorNotif(
		array('name' => 'state','placeholder' => 'State/Province/Region'));
	echo '</div><div class="col-sm-6">';
	form_input_wErrorNotif(
		array('name' => 'postal','placeholder' => 'Postal'));
	echo '</div><div class="col-sm-6">';
	form_input_wErrorNotif(
		array('name' => 'country','placeholder' => 'Country'));
echo '</div></div> ';
?>

	<div class='col-md-6 form-check select-course multi-course pt-3'>
		<label class='form-check-label'>
			<input type="checkbox"  id="applyToMultipleCourse" class="form-check-input">
			Apply to Multiple Course
		</label>
	</div>

<div class="courseList col-sm-12 hidden">

<?php 
if (testVar($courseList))
{
    echo '<h5>BISD Courses</h5>';
    ?>
    <hr>
    <div  class="select-course">
        <div class="row">
            <?php
            $checked = array_kvp($preRequisite, 0, 'course_id');

		    foreach ($courseList as $key => $value)
		    {
		    	format_categ($key);
		    	foreach ($value as $key => $value) {
		    		$check = in_array($value['course_id'],$checked);
		    		format_course($value,$check);
		    	}
		    }

		    ?>
        </div>
    </div>
<?php } 

// courseList formatting

function format_categ($categ){

	if(strpos($categ,'Foundation Courses')>-1){
		$categ = $categ."
		<label style='font-size: 0.7rem; font-weight: 400;'> (Prerequisite to all standard and specialized courses) </label>";
	}

	echo '<div class="course-category col-12">';
	echo "<h6>$categ</h6>";
	echo '</div>';
}

function format_course($course,$checked = false){
	$id = $course['course_id'];
	$name = $course['course_name'];

	$attr = array(
            'name' => 'courseApplied[]',
            'value' => $id,
            'class' => 'form-check-input',
        );
	if($checked){
		// creates a hidden form input; this value will be submitted to the server instead of the value of the checkbox. Checkbox when disabled is not be submitted to the server.
		echo form_hidden($attr['name'],$attr['value']); 
		$attr = array_merge($attr, array('checked'=>'checked','disabled'=>''));
	}
        echo "<div class = 'col-md-6 form-check'> <label class='form-check-label'>";
        echo form_checkbox($attr, '');
        echo "$name</label>";
        echo "</div>";
}

?>

</div>

<?php
echo '<div class="col-sm-12 text-right">';
$attr = array(
        'name' => 'submit',
        'class' => 'btn btn-outline-primary',
);
echo form_submit($attr,'Submit');
echo '</div>';
?></div><?php

echo form_fieldset_close();
echo form_close();

