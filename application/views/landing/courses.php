<div class="land-courses page-body">
	
<div class="hero-image2">
        <img src="<?=PATH_IMAGES . 'img4.jpg'?> ">
  <div class="hero-text2">
    
    <h1 class="display-3">BISD COURSES</h1>
    <p class="lead"><font color="black">Benitez Institute for Sustainable Development</font></p>
 
  </div>
  <br><br><br>
  

  
  </div>
		
		<div class="container">
		<?php

            foreach ($courseList as $key => $courseCateg) {
                format_category($key);
                echo '<div class="categ-courses">';
                foreach ($courseCateg as $course) {
                    format_course($course);
                }
                echo '</div>';
            }

        ?>
	</div>
</div>



<?php

// functions for formatting html

	function format_course($course)
	{
		$src = IMG_DEF;
		$path = RESRC_PATH.$course['img_path'];
		if(file_exists($path) && is_file($path)){
			$src = RESRC.$course['img_path'];
		}

?>
		<div class="course">
			<h3><?=$course['course_name']?></h3>
			<hr>

			<div class="course-img" 
				style="background-image: url('<?=$src?>');" >
				<div class="course-desc">
					<?=newLine_to_pTag($course['description']);?>
				</div>

			</div>
		</div>
<?php
	}
	function format_category($categName)
	{
?>
		<div class="course-category">
			<h2><?=$categName?></h2>
		</div>


<?php 
	}
?>
