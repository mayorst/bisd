<?php
$CI = &get_instance();

// adds the chage logo form
$CI->load->view('management/templates/logo_form');
?>

<div class="dashboard page-body">
	<div class="container">
		<div class="row">
			<div class="col-md-2 align-center">
				<div class="logo ">
					<a class="btn btn-outline-primary edit-logo" href="#"
						onclick="showElem('#id_update_logo')">

						<i class="fa fa-pencil-alt"></i></a>
					<img class="vcenter" src="<?=$config['path_logo']?>">
				</div>
			</div>
			<div class="col-md-10 align-center heading">
				<h1>Benitez Institute for Sustainable Development</h1>
			</div>
		</div>
		<hr>
	</div>
</div>
