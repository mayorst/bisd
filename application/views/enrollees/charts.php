
<div class="enrollee-charts page-body">
	<div class="mngmnt-heading">Course Enrollees</div>
	<div class="container">
		<div class="pt-2 align-right">
			<a class="btn btn-outline-primary" href="<?=base_url('enrollees/reports')?>"><i class=" fa fa-clipboard"></i> Reports</a>
		</div>

		<div>
			<h4>Inquiries on BISD Courses</h4>
			<hr>
			<h6 class="w-100 text-center">-- <?=testVar($dateRange)?> --</h6>

			<div id="googleChart" style="width: 100%; height: 350px;"></div>
		</div>

		<div class="w-100">
			<h4 class="tbl-title">Course Inquiries</h4>
			<span class="float-right">
				<?=testVar($dateRange)?>
			</span>
		</div>
		<div class="my-tbl">
			<?php
				echo testVar($tblEnrollees);
			?>
		</div>
	</div>
</div>


<script type="text/javascript">
	google.charts.load("current", { packages: ["corechart"] });
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		<?php 

	        foreach ($courseInquiry_chart as $key => $value) {
	            $courseInquiry_chart[$key] = json_encode(array_values($value),JSON_NUMERIC_CHECK );
	        }
	       $chartValues =  implode(', ',$courseInquiry_chart);
		?>

		var data = google.visualization.arrayToDataTable([
			['Task', 'BISD Course'],
			<?=$chartValues?>
		]);

		var options = {
			// title: 'Inquiries on BISD Courses',
			pieHole: 0.4,
        	// sliceVisibilityThreshold: .1
		};

		var chart = new google.visualization.BarChart(document.getElementById('googleChart'));
		chart.draw(data, options);
	}

</script>