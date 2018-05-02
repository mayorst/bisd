<?php
    /**
     * NOTE:
     * $tblMember - array of the database query
     *
     *
     */
?>


	<div class="page-body manage-account">
		<div class="container">

			<h4>Members</h4>
			<div class="tbl-member">
				<?php
                    echo testVar($tblMember);
                ?>
			</div>
			<div class="align-right">
				<a class="btn btn-outline-primary" href="<?=base_url("accounts/create");?>">Create Account</a>
			</div>
		</div>
	</div>