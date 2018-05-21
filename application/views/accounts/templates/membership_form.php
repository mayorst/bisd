<?php
    /**
     * $view_setting - array of config, used to remove or add an element
     * $type - use for the viewing type: Update or Create
     * $form_action - url to submit form
     * $user_to_update - array of the information of a member
     * if public_variables::UPDATE
     *     -  removes the #userCredential
     *
     */
?>
	<div class="membership-form">
		<?php
            use \public_variables as pv;

            $userInfo = (testVar($user_to_update)) ? $user_to_update : testVar($_SESSION['user']);

            echo form_open(testVar($form_action));
            echo form_fieldset();
        ?>
			<h4><?=isset($title) ? $title : 'Account'?></h4>
			<?php if ((isset($view_setting) && is_array($view_setting)) && in_array('withCredential', $view_setting)) {
                ?>
			<div id="userCredential">
				<?php

                        $CI = &get_instance();
                        $data['view_setting'] = array('inputOnly');
                        $data['title'] = '';
                        $CI->load->view('accounts/templates/credential_form', $data);
                    ?>
					<div class="form-group align-right">
						<a href="javascript:window.history.go(-1);" class="btn btn-outline-danger right-button">Back</a>
						<a class="btn btn-outline-success right-align" href="#userInfo" onclick="showElem('#userInfo'); hideElem('#userCredential');">Next</a>
					</div>
			</div>
			<script>
			$(window).on('load', function() {
				$('#userInfo').attr("class", "hidden");
			});
			</script>
			<?php }?>
			<div id="userInfo">
				<?php echo form_fieldset(); ?>
				<div class="row">
					<div class="col-md-4">
						<?php form_input_wLabel(array('label' => 'last_name'), (($type === pv::UPDATE) ? $userInfo['last_name'] : ''));?> </div>
					<div class="col-md-4">
						<?php form_input_wLabel(array('label' => 'first_name'), (($type === pv::UPDATE) ? $userInfo['first_name'] : ''));?> </div>
					<div class="col-md-4">
						<?php form_input_wLabel(array('label' => 'middle_name'), (($type === pv::UPDATE) ? $userInfo['middle_name'] : ''));?> </div>
				</div>
				<?php echo form_fieldset_close();
                echo form_fieldset(''); ?>
				<div class="row">
					<div class="col-md-5">
						<?php
                            $d = date('Y-m-d');
                            $date = strtotime($d . ' -18 year');
                            $date = date('Y-m-d', $date);
                        form_input_wLabel(array('label' => 'birthdate', 'input' => array('type' => 'date')), (($type === pv::UPDATE) ? $userInfo['birthdate'] : $date));?>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label for="select_gender">Gender</label>
							<?php
                                $gender = pv::GENDER;
                                echo form_dropdown('gender',
                                    $gender,
                                    strtolower(($type === pv::UPDATE) ? $userInfo['gender'] : $gender['male']),
                                'class="form-control"  id="select_gender"');?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
						<?php form_input_wLabel(array('label' => 'contact_number'), (($type === pv::UPDATE) ? $userInfo['contact_number'] : ''));?>
					</div>
					<div class="col-md-5">
						<?php
                            $attr = array(
                                'label' => 'email',
                                'input' => array(
                                    'type' => 'email'));

                            if (($type === pv::UPDATE)) {
                                $attr['input']['readonly'] = '';
                            }
                            form_input_wLabel($attr
                            	, (($type === pv::UPDATE) ? $userInfo['email'] : '')
                            );?>
					</div>
				</div>
				<?php echo form_fieldset_close();
                echo form_fieldset(); ?>
				<div class="row">
					<div class="col-md-3">
						<?php form_input_wLabel(array('label' => 'street'), (($type === pv::UPDATE) ? $userInfo['street'] : ''));?> </div>
					<div class="col-md-3">
						<?php form_input_wLabel(array('label' => 'barangay'), (($type === pv::UPDATE) ? $userInfo['barangay'] : ''));?> </div>
					<div class="col-md-3">
						<?php form_input_wLabel(array('label' => 'municipality'), (($type === pv::UPDATE) ? $userInfo['municipality'] : ''));?> </div>
					<div class="col-md-3">
						<?php form_input_wLabel(array('label' => 'province'), (($type === pv::UPDATE) ? $userInfo['province'] : ''));?> </div>
				</div>
				<?php echo form_fieldset_close('<hr>'); ?>
				<div class="row vertical-fields">
					<div class="col-md-6 ">
						<?php echo form_fieldset(''); ?>
						<div class="form-group">
							<label for="select_position">Position</label>
							<?php
							$positions = pv::ACCOUNT_POSITION;

							$readOnly = '';
							if($userInfo['_position'] ){
								if ($type === pv::UPDATE 
									&&($userInfo['member_id'] === $_SESSION['user']['member_id']
									|| $userInfo['_position'] === $positions['admin']) ){
									$readOnly = 'readonly';
								}
							}

                                echo form_dropdown('_position',
                                    $positions,
                                    strtolower(($type === pv::UPDATE) ? $userInfo['_position'] : $positions['member']),
                                'class="form-control"  id="select_position" '.$readOnly );?>
						</div>
						<?php if (isset($type) && $type !== pv::CREATE) {
                            ?>
						<div class="">
							<label for="status">Status</label>
							<?php

							$readOnly = '';
							if($userInfo['_status'] ){
								if($userInfo['member_id'] === $_SESSION['user']['member_id']
									|| $userInfo['_position'] === $positions['admin']){
									$readOnly = 'readonly';
								}
							}

                                $status = pv::ACCOUNT_STATUS;
                                    echo form_dropdown('_status',
                                        $status,
                                        strtolower(($type === pv::UPDATE) ? $userInfo['_status'] : $status['active']),
                                    'class="form-control"  id="status" '.$readOnly);?>
						</div>
						<?php }
                        echo form_fieldset_close();?>
					</div>
				</div>
				<hr>
				<div class="form-group align-right">
					<?php
                        $event = (isset($type) && $type == pv::CREATE) ? ' onclick="backToCredential()" ' : '';
                        echo '<a href="javascript:window.history.go(-1);" ' . $event . 'class="btn btn-outline-danger right-button">Back</a>';
                        $btnSub = testVar($btnSubmit, 'Submit');
                        echo form_submit($btnSub, str_start_case($btnSub), 'class="btn btn-outline-success right-button"');
                    ?>
				</div>
			</div>
			<?php
                echo form_fieldset_close();
                echo form_close();
            ?>
	</div>