<div class="land-courses page-body">
	
<div class="hero-image vcenter-tbl-parent" >
     	<div class="bg-blur" style="background-image: url(<?=PATH_IMAGES . 'img4.jpg'?>);"></div>
		  <div class="hero-text vcenter-tbl">
		    <h1 class="display-3">BISD COURSES</h1>
		    <p class="lead"><font color="white">Benitez Institute for Sustainable Development</font></p>
		  </div>
	
  </div>
		
		<div class="container">
		<?php

            foreach ($courseList as $key => $courseCateg) {
                format_category($key);
                echo '<div class="categ-courses row">';
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
		$src=get_resc($course['img_path']);

?>
		<a href="<?=base_url('course/'.$course['course_id'])?>" class="course col-md-4 col-lg-3 ">
			<div class="course-img img_container" 
				style="background-image: url('<?=$src?>');" >
				<div>
				<!-- <div class="course-desc"> -->
					<?php//carraigeReturn_to_tag($course['description']);?>
				</div>
				<div class="more-details">
					click for more details
				</div>	
			</div>
			<hr>
			<h6 ><?=$course['course_name']?></h6>
			<hr>
		</a>
<?php
	}
	function format_category($categName)
	{
		$id = str_replace(' ','',$categName)
?>
		<div  class="course-category">
			<h2 id="<?=$id?>"><?=$categName?></h2>
		</div>
<?php 
	}
?>
