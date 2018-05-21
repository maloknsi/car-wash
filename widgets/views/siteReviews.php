<?php
use app\models\Review;
/** @var Review[] $items */
?>
<?php foreach($items as $index=>$item):?>
	<div class="item <?= !$index ? 'active' : ''?>">
		<a href="#"><?= $item->user_name ?></a>
		<p><?= $item->message?></p>
	</div>
<?php endforeach;?>
