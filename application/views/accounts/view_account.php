<div class="page-body view-account">
		<div class="mngmnt-heading">Account Information</div>
	<div class="container">
		<div class="user-info pb-before-footer">
			<div class="row">
				<div class="col-12">
					<label>User ID:</label>
					<span><?=$_SESSION['user']['member_id']?></span>
					<span class="float-right">
					<label>Username:</label>
					<span><?=$_SESSION['user']['username']?></span>
					</span>
					<hr>
				</div>
				<div class="col-12">
					<label>Name:
						<span class="name"><?=$_SESSION['user']['last_name']
. ', ' . $_SESSION['user']['first_name']
. ' ' . $_SESSION['user']['middle_name']?>
						</span>
					</label>
				</div>
				<div class="col-12 row">
						<span class="col-12"> <br></span>
					<div class="col-6">
						<label>Birthdate:</label>
						<span><?=$_SESSION['user']['birthdate']?></span>
					</div>
					<div class="col-6">
						<label>Gender:</label>
						<span><?=$_SESSION['user']['gender']?></span>
					</div>
				</div>
				<div class="col-12">
					<label>Address:</label>
					<span><?=$_SESSION['user']['street'] . ', '?></span>
					<span><?=$_SESSION['user']['barangay'] . ', '?></span>
					<span><?=$_SESSION['user']['municipality'] . ', '?></span>
					<span><?=$_SESSION['user']['province']?></span>
				</div>
				<div class="col-12 row">

					<div class="col-6">
						<label>Contact Number:</label>
						<span><?=$_SESSION['user']['contact_number']?></span>
					</div>
					<div class="col-6">
						<label>Email: </label>
						<span><?=$_SESSION['user']['email']?></span>
					</div>
				</div>
				<div class="col-12 row">
					<span class="col-12"> <br></span>
					<div class="col-md-6">
						<label>Position: </label>
						<span><?=$_SESSION['user']['_position']?></span>
					</div>
					<div class="col-md-6">
						<label>Status: </label>
						<span><?=$_SESSION['user']['_status']?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
