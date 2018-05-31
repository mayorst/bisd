<div class="single-course page-body">
	<div class="container">
		<div class="row">
			
			<div class="col-md-12" >
				<div class="course-main" >
					<div class="course-img" 
						style="background-image: 
						linear-gradient( to bottom,
							rgba(255, 255, 255, 0.0) 80%,
							rgba(255, 255, 255, 1) ),
						url('<?=get_resc(testVar($course['img_path']))?>');"></div>
					<div class="extra-padding"></div>
					<div class="course-info">
						<h2>
						<?= testVar($course['course_name'])?>
						</h2>
						<div class="course-desc">
						<?=carraigeReturn_to_tag($course['description'])?>
						</div>
						<div class="row mt-3">
							<div class="col-sm-3"> <strong>Required Course/s:</strong>
							</div><div class="col-sm-9">
							<?php 
								if($preRequisite){
									$req = array_kvp($preRequisite, 'course_id','course_name');
									$str = implode($req,', ');
								}else{
									$str = '--';
								}
							 echo carraigeReturn_to_tag($str);
							?>
							</div> 
							<div class="col-sm-3 "> <strong>Schedule: </strong>
							</div><div class="col-sm-9 sched">
							<?php 
								echo carraigeReturn_to_tag( testVar($course['course_schedule'],'--') );
							?>
							</div> 

							<div class="col-sm-3"> <strong>Tuition Fee: </strong>
							</div><div class="col-sm-9">
							<?php 
								echo 'Php '.testVar($course['tuition_fee'],'--');
							?>
							</div> 
						</div> 
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<?php 
					$CI = &get_instance();
					$CI->load->view('landing/templates/course_inquiry_form');
				?>
			</div>
			<div class="col-md-4 ">
				<div class="other-courses">
				<h4>Other Courses</h4>
				<hr>
				<div>
				<div class="list">
					<?php 
						foreach($courseList as $categ => $courseArray){
							foreach($courseArray as $key => $value){
								if($value['course_id'] === $course['course_id']){
									continue;
								}else{
									format_otherCourses($value);
								}
							}
						}
					?>
				</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<?php 
function format_otherCourses($course){
	if(is_array($course)){
		echo '<a href="'.base_url('course/'.$course['course_id']).'">';
		echo '<i class="fa fa-arrow-right"></i> '.$course['course_name'];
		echo '</a>';
	}
}

?>