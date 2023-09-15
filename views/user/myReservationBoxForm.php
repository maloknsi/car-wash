<?php

use app\helpers\OrderHelper;
use app\models\Order;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $orders app\models\Order[] */
/* @var $searchModel app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin([
    'id' => 'my-services-timetable-pjax',
    'timeout' => 240000,
    'enableReplaceState'=>false,
    'enablePushState'=>false,
    'linkSelector'=>'a',
    'clientOptions' => ['method' => 'POST'],
]); ?>
<div class="panel-body">
    <?php foreach ($orders->models as $data):?>
        <div class="user_order_item">
            <a data-pjax=true class="user_order_delete" title="Отменить заказ" href="<?= Url::to(['/site/cancel-my-reservation', 'id' => $data->id])?>">Отменить</a>
            <div class="user_order_top">
                <div><?= $data->date_start?></div>
                <div><?= date('H:i',strtotime($data->time_start))?></div>
            </div>
            <div class="user_order_servisec"><?= $data->service->title?></div>
            <div class="user_order_bottom">
                <div class="user_order_master"><?= $data->box->title?></div>
                <div class="user_order_price">от <?= $data->money_cost?>Грн</div>
            </div>
        </div>
    <?php endforeach;?>
</div>
<?php Pjax::end(); ?>
<script>
	$("document").ready(function(){
		$('#my-services-timetable-grid').parents('div#modal-form-ajax').addClass('reload-siteBoxesTimetable');
		if (!$('#btn-get_my_reservation_form').attr('form-loaded')){
			$('#btn-get_my_reservation_form').attr('form-loaded', true);
			$('#btn-get_my_reservation_form').attr('data-action-url', $('#btn-get_my_reservation_form').attr('data-action-url') + '?no-pjax=1');
		}
    });
</script>