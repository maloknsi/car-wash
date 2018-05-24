<?php

use faryshta\widgets\JqueryClockPicker;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
	'id' => 'order-form',
	'enableAjaxValidation' => true,
	'enableClientValidation' => false,
	'action' => ['save', 'id' => $model->id],
	'validationUrl' => ['validate', 'id' => $model->id],
	'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form'],
]); ?>
<div class="portlet-body">
	<div class="panel">
		<div class="panel panel-info">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<div class="col-xs-4">
					<?= $form->field($model, 'status')->textInput() ?>
				</div>
				<div class="col-xs-4">
					<?= $form->field($model, 'user_id')->textInput() ?>
				</div>
			</div>
		</div>
		<div class="panel  panel-default">
			<div class="panel-heading">Время заказа</div>
			<div class="panel-body">
				<div class="col-xs-4">
					<?php echo $form->field($model, 'date_start')->widget(DatePicker::classname(), [
						'removeButton' => false,
						'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
						'pluginOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd'
						]
					]) ?>
				</div>
				<div class="col-xs-4">
					<?php echo $form->field($model, 'time_start', ['template' => '
									   <div>{label}</div>
									   <div class="col-md-12">
										   <div class="input-group col-md-12 ">
										   	{input}
											  <span class="input-group-addon danger">
												 <span class="glyphicon glyphicon-time"></span>
											  </span>
											  
										   </div>
										   {error}{hint}
									   </div>'])->widget(JqueryClockPicker::className(),[
						'clientOptions' => [
							'autoclose' => true,
							'default' => 'now'
						],
					]); ?>
				</div>
				<div class="col-xs-4">
					<?php echo $form->field($model, 'time_end', ['template' => '
									   <div>{label}</div>
									   <div class="col-md-12">
										   <div class="input-group col-md-12 ">
										   	{input}
											  <span class="input-group-addon danger">
												 <span class="glyphicon glyphicon-time"></span>
											  </span>
											  
										   </div>
										   {error}{hint}
									   </div>'])->widget(JqueryClockPicker::className(),[
						'clientOptions' => [
							'autoclose' => true,
							'default' => 'now'
						],
					]); ?>
				</div>
			</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">Данные заказа</div>
			<div class="panel-body">
				<div class="col-xs-4">
					<?= $form->field($model, 'service_id')->textInput() ?>
				</div>
				<div class="col-xs-4">
					<?= $form->field($model, 'money_cost')->textInput() ?>
				</div>
				<div class="col-xs-4">
					<?= $form->field($model, 'box_id')->textInput() ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12 ">
			<?= $form->errorSummary($model); ?>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<?= $form->field($model, 'id')->hiddenInput()->label(''); ?>
			<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['value' => Url::to(['edit']), 'title' => 'Подтвердить действие', 'class' => 'showModalButton btn btn-success']); ?>
			<?= Html::button('Закрыть', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
