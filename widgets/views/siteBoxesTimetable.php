<?php
/** @var mixed $boxesTimetable */
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php foreach ($boxesTimetable as $index => $boxTimetable): ?>
	<div class="panel panel-info">
		<div class="panel-heading"><?= $boxTimetable['title'] ?></div>
		<div class="panel-body">
			<div class="col-xs-12">
				<h2><?= $boxTimetable['title'] ?></h2>
			</div>
			<?php if (isset($boxTimetable['timetable'])): ?>
				<?php foreach ($boxTimetable['timetable'] as $timetable): ?>
					<div class="col-xs-12">
						<div class="form-group">
								<?= Html::label($timetable['time_start'] . ' - ' . $timetable['time_end'])?>
								<?php if (!$timetable['order_id']): ?>
									<?= Html::button('Записаться', ['value' => Url::to(['edit']), 'title' => 'Записаться', 'class' => 'showModalButton btn btn-success']); ?>
								<?php else: ?>
									<?= Html::button('Занято', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
								<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
<?php endforeach; ?>
