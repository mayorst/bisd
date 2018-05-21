<div class="event-landing page-body">
<div class="hero-image" style="background-image: url('<?=PATH_IMAGES . 'img7.jpg'?>');">
	<div class="vcenter">
		<div class="hero-text2">
			<h1 class="display-3">BISD EVENTS</h1>
			<p class="lead">
				<font color="black">Benitez Institute for Sustainable Development</font>
			</p>
		</div>
	</div>
</div>

	<div class="container">
<?php

	if($eventList){
		foreach($eventList as $key => $value){
			listEvents(testVar($value));
		}
	}
?>
	</div>
</div>

<?php

function listEvents($event){
	if(!$event){
		return;
	}

	$img = get_resc($event['ev_img_path']);
	$unixDate = human_to_unix($event['time_start']);
	$date = date('M d, Y h:i a',$unixDate);
	$desc = str_replace("\r\n", '',$event['description']);
?>
	<div class="event container-fluid">
		<div  class="row">
			<div class="p-0 event-img col-md-4">
				<img class="" src="<?=$img?>">
			</div>
			<div class="col-md-8">
				<span class="date"><?=$date?></span>
				<h5><?= $event['name']?></h5>
				<?= carraigeReturn_to_tag($desc)?>
			</div>
		</div>
	</div>
<?php
}
?>