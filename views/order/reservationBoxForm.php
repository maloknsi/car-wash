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
        Только зарегистрированные пользователи могут бронировать время записи, это совсем не долго - нужен только Ваш номер телефона<br><br><br>
        <a href="#" data-action-url = "<?=Url::to('/login')?>" type="submit" class="button big btn-show-modal-form btn btn-success">Войти</a>
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
            <input name="Order[date_start]" list="brow" value="<?= $order->date_start?>" type="text" onfocus="this.value=''" onchange="this.blur();" placeholder = "Дата" class="input">
            <datalist id="brow">
                <option value="<?= date('Y-m-d', strtotime($order->date_start))?>">
                <?php for ($i = 1; $i < 5; $i++):?>
                    <option value="<?= date('Y-m-d', strtotime('+'.$i.' days', strtotime($order->date_start)))?>">
                <?php endfor;?>
            </datalist>
            <div class="invalid-feedback"></div>
        </div>
        <div class="filter_saller_item">
            <svg class="search_svg"><use xlink:href="#time_time"></use></svg>
            <select id="services" name="Order[service_id]" placeholder = "Вибрать услугу *" class="input" onfocus="this.value=''" onchange="this.blur();">
                <?php foreach ($availableServices as $service):?>
                    <option value="<?= $service->id?>"><?= $service->title?></option>
                <?php endforeach;?>
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <div class="radio filter-group ">
            <p class="pdn-left">Время:</p>
            <?php for ($i = 1; $i < 100; $i = $i+10):?>
            <div>
                <input name="Order[time_start]" value="<?= date('H:i', strtotime('+'.$i.' minutes', strtotime($order->time_start)))?>"
                       type="radio" id="start_time-<?= $i?>" name="radio-group">
                <label for="start_time-<?= $i?>"><span><?= date('H:i', strtotime('+'.$i.' minutes', strtotime($order->time_start)))?></span></label>
            </div>
            <?php endfor;?>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-auth field-loginform-password required">
            <input type="text" id="loginform-password" class="input" name="Order[description]" value="" placeholder="Описание (марка, цвет авто)*" aria-required="true">
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <?= $form->errorSummary($order); ?>
    <BR>
    <?= $form->field($order, 'id')->hiddenInput()->label(''); ?>
    <?= $form->field($order, 'box_id')->hiddenInput(['id'=>'order-box_id'])->label(''); ?>
    <button type="submit" class="button big" name="login-button">Забронировать</button>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
<?php endif; ?>
<?php
$script = <<< JS
	$("document").ready(function(){
		$('#order-date_time_start').on('change', function () {
			$.pjax.reload({container:'#services-timetable-pjax', url: "/site/get-reservation-box-form", 'push':false, 'replace': false});
		});
		$('#services-timetable-pjax').on('pjax:beforeSend', function (e, jqXHR, settings) {
			settings.url = settings.url + '&s[date_time_start]='+$('#order-date_time_start').val()+'&s[box_id]='+$('#order-box_id').val();
		});
    });
JS;
$this->registerJs($script);
?>
<script>
	$('#my-services-timetable-grid').parents('div#modal-form-ajax').addClass('reload-siteBoxesTimetable');
</script>