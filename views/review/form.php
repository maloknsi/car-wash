<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
	'id' => 'review-form',
	'enableAjaxValidation' => true,
	'enableClientValidation' => false,
	'action' => ['save', 'id' => $model->id],
	'validationUrl' => ['validate', 'id' => $model->id],
	'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form'],
]); ?>
<div class="portlet-body">
	<div class="panel">
		<div class="panel panel-info">
			<div class="panel-heading">Пользователь</div>
			<div class="panel-body">
				<div class="col-xs-4">
					<?= $form->field($model, 'user_name')->textInput() ?>
				</div>
				<div class="col-xs-4">
					<?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-xs-4">
					<?= $form->field($model, 'user_phone')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-xs-12">
					<?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
				</div>
			</div>
		</div>
		<div class="panel  panel-danger">
			<div class="panel-heading">Управление</div>
			<div class="panel-body">
				<div class="col-xs-6">
					<?= $form->field($model, 'created_at')->textInput() ?>
				</div>
				<div class="col-xs-6">
					<?= $form->field($model, 'status')->dropDownList(\app\helpers\ReviewHelper::$statuses) ?>
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
			<?= $form->field($model, 'id', [
				'options'=>['tag'=>false],
				'errorOptions' => [],
			])->hiddenInput()->label(''); ?>
			<?= $form->field($model, 'required_one_of_many_fields', [
				'options'=>['tag'=>false],
				'errorOptions' => [],
			])->hiddenInput()->label(''); ?>
			<?= $form->field($model, 'id')->hiddenInput()->label(''); ?>
			<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['value' => Url::to(['create']), 'title' => 'Подтвердить действие', 'class' => 'showModalButton btn btn-success']); ?>
			<?= Html::button('Закрыть', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
