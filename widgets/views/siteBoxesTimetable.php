<?php
/** @var mixed $boxesTimetable */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<?php Pjax::begin(['id' => 'site-boxes-timetable-pjax', 'timeout' => 7000, 'enablePushState' => false,'enableReplaceState' => false,'clientOptions' => ['method' => 'POST']]); ?>
<?php foreach ($boxesTimetable as $boxId => $boxTimetable): ?>
	<div class="col-xs-12 col-sm-6 col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading"><?= $boxTimetable['title'] ?></div>
			<div class="panel-body">
				<?php if (isset($boxTimetable['timetable'])): ?>
					<?php foreach ($boxTimetable['timetable'] as $timetable): ?>
						<div class="col-xs-12">
							<div class="form-group">
								<?php if (
									(date('Y-m-d') > $boxTimetable['date_start']) ||
									(date('Y-m-d') == $boxTimetable['date_start'] && date('H:i') > $timetable['time_start'])
								): ?>
									<?= Html::button(($timetable['time_start'] . ' - ' . $timetable['time_end']), [
										'title' => '-'.date('Y-m-d').'-'.$timetable['date_start'],
										'class' => 'btn grey-mint',
									]); ?>
								<?php elseif($timetable['order_id']): ?>
									<?= Html::button(($timetable['time_start'] . ' - ' . $timetable['time_end']
										. ' - Занято'), [
										'title' => 'Занято',
										'class' => 'btn grey-mint',
									]); ?>
								<?php else:?>
									<?= Html::button(($timetable['time_start'] . ' - ' . $timetable['time_end']
										. ' - Записатися'), [
										'title' => 'Записатися',
										'class' => 'btn-show-modal-form btn btn-success',
										'data-action-url' => Url::to([
											'site/get-reservation-box-form',
											'Order[date_start]' => $boxTimetable['date_start'],
											'Order[time_start]' => $timetable['time_start'],
											'Order[box_id]' => $boxId,
										]),
									]); ?>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php Pjax::end(); ?>
