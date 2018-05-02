<div class="container page-body">
	<div class="login-input">
		<?php
            echo form_open();
            echo form_fieldset();

            $data = array(
                'label' => 'Username',
                'lblIcon' => '<i class="fa fa-user"></i>',
            );
            form_input_wLabel($data);

            $data = array(
                'label' => 'Password',
                'lblIcon' => '<i class="fa fa-key"></i>',
                'input' => array('type' => 'password', 'value' => ''),
            );
            form_input_wLabel($data);
        ?>
		<div class=" align-right">
			<button type="submit" class="btn btn-primary right-button">LOGIN</button>
		</div>
		<?=form_fieldset_close();form_close()?>
	</div>
</div>
