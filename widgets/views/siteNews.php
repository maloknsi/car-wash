<?php
use app\models\News;
/** @var News[] $items */
?>
<div class="item active">
	<div class="row">
		<?php foreach($items as $index=>$item):?>
			<div class="col-sm-4">
				<div class="single-event">
					<h4><?= $item->title?></h4>
					<h5><?= $item->content?></h5>
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>
