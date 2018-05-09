<div class="mngmnt-heading">Update Course</div>
<div class="container">
    <div class="align-center">
        <div class="pt-2 pb-2 align-right">
            <a class="btn btn-outline-primary" href="<?=base_url('management/course/create')?>">Create</a>
            <a class="btn btn-outline-primary" href="<?=base_url('management/course/update')?>">Update</a>
        </div>
        <?php
            $CI = &get_instance();

            if (testVar($update) && testVar($courseList) && !testVar($courseToUpdate)) {
            ?>
            <div class="container select-course">
                <h3>Select Course to Update</h3>
                <hr>
                <div class="row">
                    <?php
                        $check = true;
                            foreach ($courseList as $key => $value) {
                                $attr = array(
                                    'name' => 'update_courseID',
                                    'value' => "$key",
                                    'class' => 'form-check-input',
                                );
                                echo "<div class = 'col-md-6 form-check'> <label class='form-check-label'>";
                                echo form_radio($attr, '', $check);
                                echo "$value</label>";
                                echo "</div>";
                                $check = false;
                            }

                        ?>
                </div>
                <hr>
                <div class="align-right">
                    <butto id="btn_selectCourse" class="btn btn-outline-primary">Select Course</button>
                </div>
            </div>
            <?php } else {
                    $CI->load->view('management/templates/course_form');
                }
            ?>
    </div>
</div>
