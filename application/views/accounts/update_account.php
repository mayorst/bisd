<div class="page-body">
	<div class="bg-color-blue mngmnt-heading">Update Account</div>
	<div class="wrapper">
		<nav id="sidebar">
			<!-- Sidebar Links -->
			<ul class="list-unstyled components">
				<li class="active"><a href="#accountInfo" onclick="showOneChild('#accountInfo', '.main-panel div.container>div')">Account Information</a></li>
				<li><a href="#credential" onclick="showOneChild('#credential', '.main-panel div.container>div')">Credential</a></li>
			</ul>
		</nav>
		<div class="main-panel container-fluid no-padding">
			<button type="button" id="sidebarCollapse" class="navbar-btn btn btn-outline-info">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<div class="container">
				<div id="accountInfo">
					<?php
                        $CI = &get_instance();
                        $form_data['type'] = public_variables::UPDATE;
                        $form_data['title'] = 'Account Information';
                        $form_data['btnSubmit'] = 'update';
                        $form_data['user_to_update'] = testVar($user_to_update);
                        $form_data['view_setting'] = array('viewOldPass');
                        $CI->load->view('accounts/templates/membership_form', $form_data);
                    ?>
				</div>
				<div id="credential" class="align-center hidden">
					<?php
                        $CI = &get_instance();
                        $form_data = NULL;
                        $form_data['form_action'] = current_url().'#credential';
                        $form_data['title'] = "Credentials";
                        $form_data['buttons'] = array('Back' => array('class' => 'btn btn-outline-danger', 'href' => 'javascript:window.history.go(-1);'));
                        $form_data['btnSubmit'] = "update";
                        $CI->load->view('accounts/templates/credential_form', $form_data);
                    ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
// var hash = window.location.hash.substr(1);
var hash = window.location.hash;
if (hash) {
	showOneChild(hash, ".main-panel div.container>div");
}
</script>