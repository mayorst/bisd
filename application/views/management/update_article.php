<?php 
$CI = &get_instance();

// adds the chage logo form
$CI->load->view('management/templates/logo_form');
?>
<div class="update-article page-body">
	<div class="container">
		<div class="row">
			<div class="col-md-2 align-center">
				<div class="logo">
					<a class="btn btn-outline-primary edit-logo" href="#" onclick="showElem('#id_update_logo')">

						<i class="fa fa-pencil-alt"></i></a>
					<img class="vcenter" src="<?=$config['path_logo']?>">
				</div>
			</div>
			<div class="col-md-10 align-center heading">
				<h1>Benitez Institute for Sustainable Development</h1>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<div class="other-courses">
					<h4>Articles List</h4>
					<div class="list">
						<?php format_articles(testVar($articleList));?>
					</div>
				</div>
			</div>
			<div class="website-message col-md-8">
				<div class="webmess-header row">
					<h2 class="col-sm-10"><?=testVar($articleAction,'Article:')?></h2>
				</div>
				<br>
				<?php
					$CI->load->view('management/templates/public_message_form');
				?>
			</div>
		</div>
	</div>
</div>
<?php

function format_articles($articles)
{
    if (is_array($articles))
    {
        foreach ($articles as $key => $value)
        {
            echo '<a href="' . base_url('management/article/update/' . $value['pmess_id']) . '">' . $value['title'] . '</a>';
        }
    }

}

?>
	<
