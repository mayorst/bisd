<div class="page-body">
	<div class="mngmnt-heading">Event Management</div>
	<div class="container">
		<div class="pt-2 pb-2 align-right">
			<a class="btn btn-outline-primary" href="<?=base_url('events/view_venue')?>">Venues</a>
		</div>
		<div>
			<h4 class="tbl-title">Events</h4>
			<div class="my-tbl">
				<?php
                    echo testVar($tblEvents);
                ?>
			</div>
			<div class="mt-2 text-right pb-before-footer">
				<a class="btn btn-outline-primary" href="<?=base_url('events/create')?>">Create Event</a>
			</div>
		</div>
	</div>
</div>
