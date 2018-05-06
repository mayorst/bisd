<?php
    /**
     * NOTES:
     * $courseToUpdate - if set populate form with this data
     *
     *
     */

    echo form_open();
    echo form_fieldset();

    $form_title = testVar($courseToUpdate) ? 'Update Course' : 'Create Course';
?>
    <h3><?=$form_title?></h3>
    <?php

        form_input_wLabel("course_name",
            testVar($courseToUpdate['course_name']));
    ?>
        <div class="form-group">
            <?php
                $categ = (isset($categ)) ? $categ : array();
                echo form_label('Category', 'id_categ');

                $dd = array(
                    'name' => 'category',
                    'id' => "id_categ",
                    'class' => "form-control",
                );
                echo form_dropdown($dd, $categ,
                    array(testVar($courseToUpdate['category'])));
                echo form_inputFeedback($dd['name']);
            ?>
        </div>
        <?php
            if (testVar($courseList)) {
                echo form_label('Pre Requisite', 'id_prereq');
            ?>
            <div id="id_prereq" class="container select-course">
                <div class="row">
                    <?php

                            foreach ($courseList as $key => $value) {
                                $checked = false;
                                if (testVar($coursePrereq) && in_array("$key", $coursePrereq)) {
                                    $checked = true;
                                }

                                $disabled = '';
                                if (testVar($requiredBy_course) && in_array("$key", $requiredBy_course)) {
                                    $disabled = ' disabled ';
                                }

                                $attr = array(
                                    'name' => 'preReq[]',
                                    'value' => "$key",
                                    'class' => 'form-check-input',
                                );
                                echo "<div class = 'col-md-6 form-check " . $disabled . "'> <label class='form-check-label'>";
                                echo form_checkbox($attr, '', $checked, $disabled);
                                echo "$value</label>";
                                echo "</div>";
                            }

                        ?>
                </div>
            </div>
            <?php }
                echo form_label('Course Description', 'id_txtDesc');
                echo form_textarea(array('name' => 'description', 'rows' => '10', 'cols' => '1', 'class' => 'form-control', 'id' => 'id_txtDesc'), testVar($courseToUpdate['description'])
                );
                echo form_inputFeedback('description');
            ?>
            <div class="align-right">
                <?php
                    $value = testVar($update) ? 'Update Course' : 'Create Course';

                    echo form_submit(array('class' => 'btn btn-outline-primary'), $value);
                ?>
            </div>
            <?php
                echo form_fieldset_close();
                echo form_close();
            ?>
