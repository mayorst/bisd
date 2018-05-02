<div class="land-courses page-body">
	<div class="container">
		<div>
			<h2>BISD Courses</h2>
			<hr>
		</div>
		<?php

                foreach ($courseList as $key => $courseCateg) {
                    format_category($key);
                    foreach ($courseCateg as $course) {
                        format_course($course['course_name'], $course['description']);
                    }
                }

            ?>
	</div>
</div>



<?php

    // functions for formatting html

    function format_course($name, $description)
    {
    ?>
	<div>
		<h4><?=$name?></h4>
		<div class="course-desc">
			<?=newLine_to_pTag($description);?>
		</div>
	</div>
	<?php }
        function format_category($categName)
        {
        ?>
	<div class="course-category">
		<h2><?=$categName?></h2>
	</div>
	<?php }?>
