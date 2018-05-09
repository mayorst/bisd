<?php

    echo form_open_multipart('', 'id="venue-form" ');
    echo form_fieldset('', 'class="container"');

    $title = testVar($formUpdate['title']) ? $formUpdate['title'] : 'Create Venue';
    //I dont use $title for now.
    echo "<h4>Please Fill Out the Venue Form </h4>";
?>
	<div class="row">
		<div class="col-md-6">
			<?php
                $name = testVar($formUpdate['venue_name']) ? $formUpdate['venue_name'] : '';
                form_input_wLabel("venue_name", $name);

                $addr = testVar($formUpdate['address']) ? $formUpdate['address'] : '';
                echo form_label('Address', 'id_addr');
                echo form_textarea(array('name' => 'address', 'rows' => '2', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_addr'), $addr
                );
                echo form_inputFeedback('address');
            ?>
		</div>
		<div class="col-md-6">
			<label for="id_imgUpload">Venue Image: </label>
			<div id="id_imgUpload" class="text-center img_container">
				<?php
                    $img = RESRC;

                    if (isset($formUpdate['img_path'])) {
                        if (is_array($formUpdate['img_path']) && count($formUpdate['img_path']) > 0) {
                            $img .= $formUpdate['img_path'][0]; // if array return the first
                        } else {
                            $img .= $formUpdate['img_path'];
                        }
                    } else {
                        $img = IMG_DEF;
                    }

                ?>
				<img id="img_venue" src="<?=$img?>" alt="Please Add an Image">
				<div class="upload-btn-wrapper btn-upload-venue-img">
					<button class="btn btn-primary"><i class="fa fa-plus"></i></button>
					<?php
                        $uploadExtra = 'onchange="previewImage(\'id_uploadImg\',\'img_venue\')"';
                        echo form_upload(array('name' => 'img_path', 'id' => 'id_uploadImg', 'class' => 'form-control-file')
                            , ''
                            , $uploadExtra);
                    ?>
				</div>
			</div>
		</div>
		<div class="col-12">
			<?php
                $desc = testVar($formUpdate['venue_description']) ? $formUpdate['venue_description'] : '';
                echo form_label('Venue Description', 'id_vdesc');
                echo form_textarea(array('name' => 'venue_description', 'rows' => '4', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_vdesc'), $desc);
                echo form_inputFeedback('venue_description');

            ?>
				<div>
					<div class="text-right mt-2 col-12">
						<?php
                            $str = testVar($formUpdate['submitStr']) ? $formUpdate['submitStr'] : 'Create Venue';
                        echo form_submit('', $str, 'class="btn btn-outline-primary"');?>
					</div>
				</div>
				<?php

                    echo form_fieldset_close();
                echo form_close();
