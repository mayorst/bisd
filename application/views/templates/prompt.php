<div class="float-prompt">
	<?php if ($this->session->flashdata('log_error')) {?>
	<div class="alert alert-dismissible alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h6><?=(isset($this->session->flashdata('log_error')['title'])) ? $this->session->flashdata('log_error')['title'] : ''?></h6>
		<hr>
		<?=(isset($this->session->flashdata('log_error')['body'])) ? $this->session->flashdata('log_error')['body'] : ''?>
	</div>
	<?php }?>
<?php if ($this->session->flashdata('log_success')) {
    ?>
	<div class="alert alert-dismissible alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h6><?=(isset($this->session->flashdata('log_success')['title'])) ? $this->session->flashdata('log_success')['title'] : ''?></h6>
		<hr>
		<?=(isset($this->session->flashdata('log_success')['body'])) ? $this->session->flashdata('log_success')['body'] : ''?>
	</div>
	<?php }?>
</div>
<?php
    $CI = &get_instance();
    $CI->load->helper('modal');

	modal_YesNo();
?>

<?php 
unset($_SESSION['log_success'],$_SESSION['log_error'])
?>