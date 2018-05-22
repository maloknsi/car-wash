<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Box */
/* @var $form yii\widgets\ActiveForm */
?>


<h3>Оставить отзыв</h3>
<div class="status alert alert-success" style="display: none"></div>
	<?php $form = ActiveForm::begin([
		'id' => 'main-contact-form',
		'enableAjaxValidation' => true,
		'enableClientValidation' => false,
		'action' => ['site/send-review'],
		'validationUrl' => ['site/send-review-validate'],
		'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form'],
	]); ?>
	<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'user_phone')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
	<?= $form->field($model, 'required_one_of_many_fields', [
		'options'=>['tag'=>false],
		'errorOptions' => [],
	])->hiddenInput()->label(''); ?>

	<?= $form->errorSummary($model); ?>
	<?= Html::submitButton('Отправить', ['value' => Url::to(['site/send-review']), 'title' => 'Отправить', 'class' => 'showModalButton btn btn-primary pull-right']); ?>
<?php ActiveForm::end(); ?>