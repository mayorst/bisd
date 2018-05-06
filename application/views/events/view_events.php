<div class="page-body">
	<div class="container">
		<div class="align-right">
			<a class="btn btn-outline-primary" href="<?=base_url('events/view_venue')?>">Venues</a>
		</div>
		<div>
			<h3>Events</h3>
			<div class="my-tbl">
				<?php
                    echo testVar($tblEvents);
                ?>
			</div>
			<div class="mt-2 text-right">
				<a class="btn btn-outline-primary" href="">Create Event</a>
			</div>
		</div>
		<?php
            $CI = &get_instance();
            $CI->load->view('events/templates/events_form');
        ?>
	</div>
</div>
