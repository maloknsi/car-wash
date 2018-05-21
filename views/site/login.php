<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin([
	'id' => 'login-form',
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'action' => ['/login'],
	'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form-site'],
]); ?>
<div class="portlet-body">
	<div class="panel">
		<div class="panel panel-info" id="panel_input_phone">
			<div class="panel-heading">Введите свой номер телефона</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<?= $form->field($model, 'smsPhone')->widget(\yii\widgets\MaskedInput::className(), [
						'mask' => '+380(99) 999-9999',
					]) ?>
				</div>
			</div>
		</div>
		<div class="panel panel-danger"  id="panel_input_sms_code" style="display: none;">
			<div class="panel-heading">Введите пароль подтверждения из SMS</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<?= $form->field($model, 'smsCode')->textInput(['maxlength' => true]) ?>
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
			<?= Html::submitButton('Войти', ['value' => Url::to(['/login']), 'title' => 'Подтвердить действие', 'class' => 'showModalButton btn btn-success', 'name' => 'login-button']); ?>
			<?= Html::button('Закрыть', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
