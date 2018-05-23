<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $order app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if(Yii::$app->user->isGuest):?>
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
<?php else:?>
	<?php $form = ActiveForm::begin([
		'id' => 'order-form',
		'enableAjaxValidation' => true,
		'enableClientValidation' => false,
		'action' => ['order/save'],
		'validationUrl' => ['order/validate'],
		'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form'],
	]); ?>
	<div class="portlet-body">
		<div class="panel">
			<div class="panel panel-info">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<div class="col-xs-4">
						<?= $form->field($order, 'status')->textInput() ?>
					</div>
					<div class="col-xs-4">
						<?= $form->field($order, 'user_id')->textInput() ?>
					</div>
				</div>
			</div>
			<div class="panel  panel-default">
				<div class="panel-heading">Время заказа</div>
				<div class="panel-body">
					<div class="col-xs-4">
						<?= $form->field($order, 'date_start')->widget(DatePicker::classname(), [
							'removeButton' => false,
							'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
							'pluginOptions' => [
								'autoclose' => true,
								'format' => 'yyyy-mm-dd'
							]
						]) ?>
					</div>
					<div class="col-xs-4">
						<?= $form->field($order, 'time_start')->widget(DateTimePicker::classname(), [
							'removeButton' => false,
							'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
							'pickerButton' => ['icon' => 'time'],
							'pluginOptions' => [
								'showMeridian'=>false,
								'template' => false,
								'autoclose'=>true,
								'format' => 'hh:ii',
							]
						]) ?>
					</div>
					<div class="col-xs-4">
						<?= $form->field($order, 'time_end')->widget(DateTimePicker::classname(), [
							'removeButton' => false,
							'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
							'pickerButton' => ['icon' => 'time'],
							'pluginOptions' => [
								'showMeridian'=>false,
								'template' => false,
								'autoclose'=>true,
								'format' => 'hh:ii',
							]
						]) ?>
					</div>
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">Данные заказа</div>
				<div class="panel-body">
					<div class="col-xs-4">
						<?= $form->field($order, 'service_id')->textInput() ?>
					</div>
					<div class="col-xs-4">
						<?= $form->field($order, 'money_cost')->textInput() ?>
					</div>
					<div class="col-xs-4">
						<?= $form->field($order, 'box_id')->textInput() ?>
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
				<?= Html::submitButton($order->isNewRecord ? 'Создать' : 'Обновить', ['value' => Url::to(['edit']), 'title' => 'Подтвердить действие', 'class' => 'showModalButton btn btn-success']); ?>
				<?= Html::button('Закрыть', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
<?php endif;?>
