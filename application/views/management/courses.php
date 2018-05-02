<div class="courses page-body">
    <div class="container align-center">
        <div class="pb-2 align-right">
            <a class="btn btn-outline-primary" href="<?=base_url('management/course/create')?>">Create</a>
            <a class="btn btn-outline-primary" href="<?=base_url('management/course/update')?>">Update</a>
        </div>
        <?php

            $CI = &get_instance();
            if (isset($update)) {
                if (testVar($update)) {
                    $CI->load->view('management/update_course');
                } else {
                    $CI->load->view('management/create_course');
                }
            } else {

            ?>
            <div class="row">
                <?php
                    if (isset($viewCourseList)) {
                            foreach ($viewCourseList as $key => $courseCateg) {
                                format_category($key);
                                foreach ($courseCateg as $course) {
                                    format_course($course['course_id'], $course['course_name'], $course['description']);
                                }
                            }
                        }

                    ?>
            </div>
            <?php }?>
    </div>
</div>
<?php
    function format_course($id, $name, $description)
    {
    ?>
    <div class="card-deck border-primary mb-3 mx-auto col-md-6">
        <div class="card p-3 text-center">
            <div class="card-header">Course No. <?=$id?></div>
            <div class="card-block">
                <h4 class="card-title"><?=$name?></h4>
                <div class="card-text course-desc">
                    <?=newLine_to_pTag($description);?>
                </div>
            </div>
            <div class="card-footer text-right">
                <a class="btn btn-outline-primary" href="<?=base_url('management/course/update/' . $id)?>">Update</a>
            </div>
        </div>
    </div>
    <?php }
        function format_category($categName)
        {
        ?>
    <div class="course-category col-12 ">
        <h2><?=$categName?></h2>
    </div>
    <?php }?>
