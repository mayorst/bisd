<?php
$CI = &get_instance();

// adds the chage logo form
$CI->load->view('management/templates/logo_form');
?>

<div class="dashboard page-body">
	<div class="container">
		<div class="row">
			<div class="col-md-2 align-center">
				<div class="logo">
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
		<div class="website-message">
			<div class="webmess-header row">
			<h2 class="col-sm-10">Article:</h2>
			<a class="col-sm-2 btn btn-outline-primary edit-article" href="<?=base_url('management/article/update')?>"><i class="fa fa-pencil-alt"></i> edit</a>
			</div>
			<br>
			<?=create_WebsiteMessage($website_message)?>
		</div>
	</div>
</div>


<?php
function create_WebsiteMessage($publicMessage)
{
    if (!empty($publicMessage))
    {
        echo '<h4>' . $publicMessage['title'] . '</h4>';
        echo '<p>' . carraigeReturn_to_tag($publicMessage['from_'], '<br>', ' ') . '</p>';

        $unix = human_to_unix($publicMessage['date_publish']);
        $published = date('M d, Y', $unix);
        echo '<p>' . $published . '</p>';

        echo '<div class="message">' . carraigeReturn_to_tag($publicMessage['message']) . '</div>';
    }
}

?>