<?php
/** @var mixed $boxesTimetable */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<?php Pjax::begin([
    'id' => 'site-boxes-timetable-pjax',
    'timeout' => 7000,
    'enablePushState' => false,
    'enableReplaceState' => false,
    'clientOptions' => ['method' => 'POST'],
    'options' => [
        'class' => 'calendar_box_list'
    ]
]);
?>
<?php foreach ($boxesTimetable as $boxId => $boxTimetable): ?>
    <div class="calendar_list">
        <h2><?= $boxTimetable['title'] ?></h2>
        <?php if (isset($boxTimetable['timetable'])): ?>
            <?php foreach ($boxTimetable['timetable'] as $timetable): ?>
                <?php if($timetable['order_id']): ?>
                    <a class="status_item order_data">
                        <div class="time"><span><?= $timetable['time_start']?></span><?= $timetable['time_end']?></div>
                        <div class="status_text">Занято</div>
                    </a>
                <?php else:?>
                    <a href="javascript:;" title="Записатися" class="status_item btn-show-modal-form" data-action-url="<?= Url::to([
                        'site/get-reservation-box-form',
                        'Order[date_start]' => $boxTimetable['date_start'],
                        'Order[time_start]' => $timetable['time_start'],
                        'Order[box_id]' => $boxId,
                    ])?>">
                        <div class="time"><span><?= $timetable['time_start']?></span><?= $timetable['time_end']?></div>
                        <div class="add_new">+</div>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($boxTimetable['can_order']): ?>
            <p><span>Вільно</span> с <?= $boxTimetable['time_start']?> по <?= $boxTimetable['time_end']?></p>
            <a href="javascript:;" title="Записатися" class="secondary radius icon_buton btn-show-modal-form" data-action-url="<?= Url::to([
                'site/get-reservation-box-form',
                'Order[date_start]' => $boxTimetable['date_start'],
                'Order[time_start]' => $boxTimetable['time_start'],
                'Order[box_id]' => $boxId,
            ])?>">Записатися</a>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<?php Pjax::end(); ?>
