<div class="page-body">
	<div class="bg-color-blue mngmnt-heading">Create Account</div>
	<div class="main-panel">
		<div class="container">
			<?php 
				$CI =&get_instance();
				use \public_variables as pv;
				$form_data['type'] = pv::CREATE;
				$form_data['view_setting'] = array('withCredential');
				$form_data['title'] = 'Create New Account';
				$form_data['btnSubmit'] = 'create_account';
				$CI->load->view('accounts/templates/membership_form',$form_data);
			?>
		</div>
	</div>
</div>