<?php

echo form_open(base_url('management/saveExternalLink'),['class'=>'form-undecorated']);
echo form_fieldset();
echo '<div class="row"> <div class="col-md-6">';
form_input_wlabel('fb_link',testVar($extLinks['fb_link']));
echo '</div> <div class="col-md-6">';
form_input_wlabel('twitter_link',testVar($extLinks['twitter_link']));
echo '</div> </div>';
echo '<div class="align-right mt-3">';
echo form_submit(['class'=>'btn btn-outline-primary'], 'Apply');
echo '</div> ';

echo form_fieldset_close();
echo form_close();




