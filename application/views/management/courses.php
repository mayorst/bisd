<div class="courses page-body">
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

        <div class="mngmnt-heading">Course Management</div>
        <div class="container align-center">
            <div class="pt-2 pb-2 align-right">
                <a class="btn btn-outline-primary" href="<?=base_url('management/course/create')?>">Create</a>
                <a class="btn btn-outline-primary" href="<?=base_url('management/course/update')?>">Update</a>
            </div>
            <div class="row">
                <?php
                    if (isset($viewCourseList)) {
                            foreach ($viewCourseList as $key => $courseCateg) {
                                format_category($key);
                                foreach ($courseCateg as $course) {
                                    format_course($course);
                                }
                            }
                        }

                    ?>
            </div>
            <?php }?>
        </div>
</div>
<?php
    function format_course($course)
    {
        $src = IMG_DEF;
        $path = RESRC_PATH.$course['img_path'];
        if(file_exists($path) && is_file($path)){
            $src = RESRC.$course['img_path'];
        }
    ?>
    <div class="card-deck border-primary mb-3 mx-auto col-md-6">
        <div class="card p-3 text-center">
            <div class="card-header">Course No.
                <?=$course['course_id']?>
            </div>
            <div class="card-block">
                <h4 class="card-title"><?=$course['course_name']?></h4>
                <div class="course-img" style="background-image: url('<?=$src?>');">
                    <div class="card-text course-desc">
                        <?=carraigeReturn_to_tag($course['description']);?>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a class="btn btn-outline-primary" href="<?=base_url('management/course/update/' . $course['course_id'])?>">Update</a>
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
