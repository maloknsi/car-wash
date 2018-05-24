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
/* @var $form yii\widgets\ActiveForm */
?>
<?php if (Yii::$app->user->isGuest): ?>
	<div class="portlet-body">
		<div class="panel">
			<div class="panel panel-danger">
				<div class="panel-heading">Ошибка</div>
				<div class="panel-body">
					<div class="col-xs-12">
						Только зарегистрированные пользователи могут бронировать время записи.<br>
						<?= Html::submitButton(
							'Зарегистрируйтесь',
							[
								'title' => 'Записаться',
								'class' => 'btn-show-modal-form btn btn-success',
								'data-action-url' => Url::to('/login'),
							]
						); ?>
						, это совсем не долго - нужен только Ваш номер телефона
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php $form = ActiveForm::begin([
		'id' => 'reservation-form',
		'enableAjaxValidation' => false,
		'enableClientValidation' => false,
		'action' => ['site/set-reservation-box'],
		'validationUrl' => ['order/validate'],
		'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form'],
	]); ?>
	<div class="portlet-body">
		<div class="panel">
			<div class="panel  panel-default">
				<div class="panel-heading">Время заказа</div>
				<div class="panel-body">
					<div class="col-xs-12">
						<?= $form->field($order, 'date_time_start')->widget(DateTimePicker::classname(), [
							'removeButton' => false,
							'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
							'pickerButton' => ['icon' => 'time'],
							'pluginOptions' => [
								'showMeridian' => false,
								'template' => false,
								'autoclose' => true,
								'format' => 'yyyy-mm-dd hh:ii',
							]
						]) ?>
					</div>
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">Доступные для бронирования услуги для этого периода времени</div>
				<div class="panel-body">
					<div class="col-xs-12">
						<? Pjax::begin(['id' => 'services-timetable-pjax', 'timeout' => 7000, 'enablePushState' => false,'clientOptions' => ['method' => 'POST']]); ?>
						<?= GridView::widget([
							'id' => 'services-timetable-grid',
							'layout' => "{items}\n{pager}\n{summary}",
							'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
							'options' => ['class' => ['table-report-detailed', 'grid-view']],
							'dataProvider' => \app\models\Box::getAvailableServices($order->box_id, $order->date_time_start),
							'columns' => [
								['class' => 'yii\grid\SerialColumn'],
								[
									'attribute' => 'title',
									'content' => function ($data) {
										/** @var Service $data */
										return "<b>{$data->title}</b><br><i>$data->description</i>";
									},
									'headerOptions' => ['style' => 'min-width: 120px;'],
								],
								[
									'attribute' => 'time_processing',
									'content' => function ($data) {
										/** @var Service $data */
										return date('H:i', strtotime($data->time_processing));
									},
									'headerOptions' => ['style' => 'min-width: 120px;'],
									'contentOptions' => ['style' => 'text-align: center'],
								],
								[
									'attribute' => 'money_cost',
									'contentOptions' => ['style' => 'text-align: center'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'template' => '{reservation}',
									'contentOptions' => ['style' => 'text-align: center'],
									'buttons' => [
										'reservation' => function ($url, $data, $key) {
											/** @var $data Service */
											return Html::radio('Order[service_id]', false, array(
												'value'=>$data->id,
												'uncheckValue'=>null
											));
										},
									],
								],
							],
						]); ?>
						<? Pjax::end(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 ">
				<?= $form->errorSummary($order); ?>
			</div>
		</div>
		<div class="modal-footer">
			<div class="form-group">
				<?= $form->field($order, 'id')->hiddenInput()->label(''); ?>
				<?= $form->field($order, 'box_id')->hiddenInput(['id'=>'order-box_id'])->label(''); ?>
				<?= Html::submitButton($order->isNewRecord ? 'Записаться' : 'Обновить', ['value' => Url::to(['edit']), 'title' => 'Подтвердить действие', 'class' => 'showModalButton btn btn-success']); ?>
				<?= Html::button('Отмена', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
<?php endif; ?>
<?php
$script = <<< JS
	$("document").ready(function(){
		$('#order-date_time_start').on('change', function () {
			$.pjax.reload({container:'#services-timetable-pjax', url: "/site/get-reservation-box-form"});
		});
		$('#services-timetable-pjax').on('pjax:beforeSend', function (e, jqXHR, settings) {
			settings.url = settings.url + '&s[date_time_start]='+$('#order-date_time_start').val()+'&s[box_id]='+$('#order-box_id').val();
		});
    });
JS;
$this->registerJs($script);
?>
