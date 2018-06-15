<?php 
$CI = &get_instance();

// adds the save pdf form
$CI->load->view('enrollees/templates/save_pdf_report_form');
?>

<div class="reports page-body">
	<div class="mngmnt-heading">Reports</div>
	<div class="container">
		<div class="report-filter align-center">
			<h4 class="text-left w-100 pt-3"><i class="fa fa-filter"></i> Filter</h4>
			<hr>
			<?php 
				$CI->load->view('enrollees/templates/reports_filter_form');
			?>
		</div>
		</div>
		<div class="container-fluid">
		<div class="generated-tbl-report">
			<div class="align-right pb-3">
				<a  class="btn btn-outline-primary" onclick="showElem('#id_save_pdf')"><i class="fa fa-print"></i> Print</a>
			</div>

			<div id="pdfReport_Table">
			<h3 class="align-center">BISD Website Enrollees</h3>
			<div class=" row">
				<h6 class="float-left col-8"><?= testVar($reportLabel,'(Report Table)')?></h6>
				<p class="align-right col-4">
					<?=testVar($dateRange,date('M d, Y'))?>
				</p>
			</div>
			<div class="my-tbl">
				<?php 
				echo testVar($tblReport);
			?>
			</div>
			</div>
		</div>
	</div> 

	
		<script type="text/javascript">
			$(document).ready(function() {
				<?php 
			if(testVar($tblReport)){
				?>
				$('.generated-tbl-report').slideDown();
				$('.report_filter').slideUp();
				<?php
			}else{
				?>
				$('.report_filter').slideDown();
				$('.generated-tbl-report').slideUp();
				<?php
			}
		?>
			});

		</script>


</div>
