<div class="container page-body">
    <div class="login-input">
        <?php
            echo form_open();
            echo form_fieldset();
        ?>
            <label>
                Please Enter Your account username to change your Password.
            </label>
                <?php
                    $data = array(
                        'label' => 'Username',
                        'lblIcon' => '<i class="fa fa-user"></i>',
                    );
                    form_input_wLabel($data);
                ?>
                    <div class=" align-right">
                        <button type="submit" class="btn btn-primary right-button">Change Password</button>
                    </div>
                    <?=form_fieldset_close();
form_close()?>
    </div>
</div>
