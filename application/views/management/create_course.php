<div class="mngmnt-heading">Create Course</div>
<div class="container">
	<div class="align-center">
		<div class="pt-2 pb-2 align-right">
			<a class="btn btn-outline-primary" href="<?=base_url('management/course/create')?>">Create</a>
			<a class="btn btn-outline-primary" href="<?=base_url('management/course/update')?>">Update</a>
		</div>
		<?php
            $CI = &get_instance();
            $CI->load->view('management/templates/course_form');
        ?>
	</div>
</div>
