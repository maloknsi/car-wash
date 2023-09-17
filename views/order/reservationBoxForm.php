<?php

use app\models\Order;
use app\models\Service;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $order app\models\Order */
/* @var $availableServices app\models\Service[] */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if (Yii::$app->user->isGuest): ?>
	<div class="portlet-body">
        Тільки зареєстровані користувачі можуть бронювати час запису, це зовсім не довго - потрібен лише Ваш номер телефону<br><br><br>
        <a href="#" data-action-url = "<?=Url::to('/login')?>" type="submit" class="button big btn-show-modal-form btn btn-success">Ввійти</a>
	</div>
<?php else: ?>
    <?php Pjax::begin(['id' => 'services-timetable-pjax', 'timeout' => 7000, 'enablePushState' => true,'clientOptions' => ['method' => 'POST']]); ?>
	<?php $form = ActiveForm::begin([
		'id' => 'reservation-form',
		'enableAjaxValidation' => false,
		'enableClientValidation' => false,
		'action' => ['site/set-reservation-box'],
		'validationUrl' => ['order/validate'],
		'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form'],
	]); ?>
    <div class="input-conteiner">
        <div class="filter_saller_item">
            <svg class="search_svg"><use xlink:href="#calendar"></use></svg>
            <select id="order-date_start" name="Order[date_start]" class="input" onfocus="this.value=''" onchange="this.blur();">
                <?php if (date('Y-m-d', strtotime($order->date_start)) > date('Y-m-d')):?>
                    <option value="<?= date('Y-m-d', strtotime('-1 day', strtotime($order->date_start)))?>">
                        <?= date('Y-m-d', strtotime('-1 day', strtotime($order->date_start)))?>
                    </option>
                <?php endif;?>
                <option selected value="<?= date('Y-m-d', strtotime($order->date_start))?>">
                    <?= date('Y-m-d', strtotime($order->date_start))?>
                </option>
                <?php for ($i = 1; $i < 5; $i++):?>
                <option value="<?= date('Y-m-d', strtotime('+'.$i.' days', strtotime($order->date_start)))?>">
                    <?= date('Y-m-d', strtotime('+'.$i.' days', strtotime($order->date_start)))?>
                </option>
                <?php endfor;?>
            </select>
            <div class="invalid-feedback"></div>
        </div>
        <div class="filter_saller_item">
            <svg class="search_svg"><use xlink:href="#time_time"></use></svg>
            <select id="order-services" name="Order[service_id]" placeholder = "Вибрать услугу *" class="input" onfocus="this.value=''" onchange="this.blur();">
                <?php foreach ($availableServices as $service):?>
                    <option <?php if($service->id == $order->service_id):?>selected<?php endif?> value="<?= $service->id?>"><?= $service->title?></option>
                <?php endforeach;?>
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <div class="radio filter-group ">
            <p class="pdn-left">Час:</p>
            <?php $timeStart = $order->box->time_start;?>
            <?php if ($order->time_start):?>
                <?php $timeStart = date('H:00',strtotime($order->time_start));?>
                <?php $timeValue = date('H:i', strtotime('-10 minutes', strtotime($timeStart)));?>
                <div>
                    <input value="<?= $timeValue?>"
                           type="radio" id="start_time" class="js-order-start_time">
                    <label for="start_time"><span><?= $timeValue?></span></label>
                </div>
            <?php endif;?>
            <?php for ($i = 0; $i < 13; $i++):?>
                <?php $timeValue = date('H:i', strtotime('+'.$i.' hours', strtotime($timeStart)));?>
                <?php if ($order->time_start):?>
                    <?php $timeValue = date('H:i', strtotime('+'.$i.'0 minutes', strtotime($timeStart)));?>
                <?php endif;?>
                <div>
                    <input name="Order[time_start]" value="<?= $timeValue?>"
                           <?php if($order->time_start == $timeValue):?>checked<?php endif?>
                           type="radio" id="start_time-<?= $i?>" class="js-order-start_time">
                    <label for="start_time-<?= $i?>"><span><?= $timeValue?></span></label>
                </div>
            <?php endfor;?>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-auth field-loginform-password required">
            <input type="text" id="loginform-password" class="input" name="Order[description]" value="" placeholder="Довідка (марка, колір авто)*" aria-required="true">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <?= $form->errorSummary($order); ?>
    <BR>
    <?= $form->field($order, 'id')->hiddenInput()->label(''); ?>
    <?= $form->field($order, 'box_id')->hiddenInput(['id'=>'order-box_id'])->label(''); ?>
    <button type="submit" class="button big" name="login-button">Забронювати</button>
    <?php ActiveForm::end(); ?>
    <?php
    $script = <<< JS
	$("document").ready(function(){
		$('#order-date_start, #order-services, .js-order-start_time').on('change', function () {
			$.pjax.reload({container:'#services-timetable-pjax', url: "/site/get-reservation-box-form", 'push':false, 'replace': false});
		});
		$('#services-timetable-pjax').on('pjax:beforeSend', function (e, jqXHR, settings) {
			settings.url = '/site/get-reservation-box-form?_pjax=services-timetable-pjax'
			+'&Order[date_start]='+$('#order-date_start').val()
			+'&Order[service_id]='+$('#order-services').val()
			+'&Order[time_start]='+$('.js-order-start_time:checked').val()
			+'&Order[box_id]='+$('#order-box_id').val();
		});
    });
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>
<?php endif; ?>
<script>
	$('#my-services-timetable-grid').parents('div#modal-form-ajax').addClass('reload-siteBoxesTimetable');
</script>