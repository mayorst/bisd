<?php

function modal_YesNo($title = 'Dialogbox', $body = 'No Message.', $yesHref='#', $noHref='#') {?>
	<div class="modal modal-yes-no">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Modal body text goes here.</p>
				</div>
				<div class="modal-footer">
					<?php if (!empty($yesHref)) {echo "<a href='$yesHref'>";}?>
					<button type="button" class="btn btn-primary">Yes</button>
					<?php if (!empty($yesHref)) {echo "</a>";}?>
					<?php if (!empty($noHref)) {echo "<a href='$noHref'>";}?>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<?php if (!empty($noHref)) {echo "</a>";}?>
				</div>
			</div>
		</div>
	</div>
<?php
}