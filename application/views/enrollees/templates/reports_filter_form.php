
<?php
$attr =  array('class'=>'report_filter_form form-undecorated');
echo form_open('',$attr);
echo form_fieldset('',['class'=>'row']);


form_input_wlabel('report_label',testVar($formValues['report_label']));

//----------
echo '<div class="row">';
$attrRange ['input'] =['type'=>'date','value'=>date('Y-m-d')];
echo '<div class="col-md-6">';
$attrRange['label'] = "Application From:";
$attrRange['input']['name'] = "range_from";
form_input_wlabel($attrRange,testVar($formValues['range_from']));
echo '</div>';

echo '<div class="col-md-6">';
$attrRange['label'] = "Application To:";
$attrRange['input']['name'] = "range_to";
form_input_wlabel($attrRange,testVar($formValues['range_to']));
echo '</div>';
echo '</div>';

//------------
echo '<div id="tbl_column" class="row form-group">';
echo '<h5 class="col-12">Select Columns to Generate: </h5>';
if(testVar($cols)){
	$colsStartCase = str_start_case($cols);
	$attrChk = array('type'=>'checkbox','class' =>'form-check-input','name'=>'columns[]' );
	foreach ($colsStartCase as $key => $value) {
		echo '<label class="form-check-label col-sm-6 col-md-4 col-lg-3">';
		$attrChk['value'] = $cols[$key];
		echo form_input($attrChk);
		echo $value;
		echo '</label>';
	}
}
echo '</div>';


echo '<div class="row">';
echo '<div class="form-group col-sm-7">';
echo '<label>Sort By:</label>';
$attr = ['id'=>'sort_on_column','name'=>'sort_column','class'=>'form-control'];
echo form_dropdown($attr);
echo form_inputFeedback($attr['name']);
echo '</div>';

echo '<div class="col-sm-5">';
echo '<div class="vcenter row">';
echo '<div class= "col-6">';
echo '<label>';
echo form_radio(['name'=>'sort_by','class'=>'form-check-input'],'ASC',true);
echo 'Ascending';
echo '</label>';
echo '</div>';

echo '<div class= "col-6">';
echo '<label>';
echo form_radio(['name'=>'sort_by','class'=>'form-check-input'],'DESC');
echo 'Descending';
echo '</label>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';


echo '<div class="align-right">'.form_submit(['class'=>'btn btn-outline-primary'],'Generate').'</div>';
echo form_fieldset_close();
echo form_close();
?>
	<hr>

<script type="text/javascript">
	$(document).ready(function() {
		$('.report_filter_form #tbl_column label').unbind("click").click(function() {
			dropdown = $('.report_filter_form #sort_on_column');
			dropdown.empty();

			var atLeastOneIsChecked = $('input[ name="columns[]" ]:checked').length > 0;

			if (atLeastOneIsChecked) {
				$('.report_filter_form #tbl_column>label').each(function() {
					chk = $(this).find(":checkbox");
					if (chk.is(':checked')) {
						option = $("<option></option>");
						option.attr('value',chk.attr('value'));
						option.text(jQuery(this).text());
						dropdown.append(option);
					}
				});
			}


		});
	});

</script>