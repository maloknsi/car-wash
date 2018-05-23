<?php
/** @var mixed $boxesTimetable */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php foreach ($boxesTimetable as $index => $boxTimetable): ?>
	<div style="float:left" class="col-sm-4 item <?= !$index ? 'active' : '' ?>">
		<a href="#"><?= $boxTimetable['title'] ?></a>
		<?php if (isset($boxTimetable['timetable'])): ?>
			<?php foreach ($boxTimetable['timetable'] as $timetable): ?>
				<div>
					<span><?= $timetable['time_start'] . ' - ' . $timetable['time_end'] ?></span>
					<?php if(!$timetable['order_id']):?>
						<?= Html::button('Записаться', ['value' => Url::to(['edit']), 'title' => 'Записаться', 'class' => 'showModalButton btn btn-success']); ?>
					<?php else:?>
						<?= Html::button('Занято', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
					<?php endif;?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php endforeach; ?>
