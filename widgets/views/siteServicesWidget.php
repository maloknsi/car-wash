<?php
use app\models\Service;

/** @var Service[] $items */
?>
<?php foreach ($items as $index => $item): ?>
	<?php if (($index % 4) == 0): ?>
		<div class="item <?= !$index ? 'active' : ''?>">
		<ul>
	<?php endif; ?>

	<li>
		<b><?= $item->title ?></b><br>
		<?php if($item->description):?>
			<i><?= $item->description ?></i><br>
		<?php endif;?>
		<span>Время выполнения</span> <?= date("H:i",strtotime($item->time_processing)) ?><br>
		<span>Стоимость</span> <?= $item->money_cost ?> <i>Грн</i>
	</li>

	<?php if ((($index+1) % 4) == 0): ?>
		</ul>
		</div>
	<?php endif; ?>

<?php endforeach; ?>
