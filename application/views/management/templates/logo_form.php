<div id="id_update_logo" class="custom-modal container">
<?php 

echo form_open_multipart();
echo form_fieldset();

echo form_hidden('logo_form');
?>

<div class="row">
    <div class="col-12">
        <label for="id_imgUpload">Website Logo: </label>
        <div id="id_imgUpload" class="text-center img_container">
            <?php
                $img = get_resc('');
            ?>
                <img id="img_event" src="<?=$img?>" alt="Please Add an Image">
                <div class="add-img upload-btn-wrapper  ">
                    <button class="btn btn-primary"><i class="fa fa-plus"></i></button>
                    <?php
                        $uploadExtra = 'onchange="previewImage(\'id_uploadImg\',\'img_event\')"';

                        echo form_upload(
                            array('name' => 'img_path', 'id' => 'id_uploadImg', 'class' => 'form-control-file')
                            , ''
                            , $uploadExtra);
                    ?>
                </div>
        </div>
    </div>
</div>
<div class="align-right mt-3">
	<a class="custModal-cancel btn btn-outline-primary">Cancel</a>
	<?php
		$form_submit = array(
			'class' => 'btn btn-outline-primary',
			);
		echo form_submit($form_submit,'Save')?>
</div>

<?php
echo form_fieldset_close();
echo form_close();
?>

</div>
