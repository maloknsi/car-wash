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

<div class="input-conteiner">
    <div class="form-auth field-loginform-email required" id="panel_input_phone">
        <?= $form->field($model, 'smsPhone')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '+380(99) 999-9999',
        ]) ?>
    </div>
    <div class="form-auth field-loginform-password required" id="panel_input_sms_code" style="display: none;">
        <?= $form->field($model, 'smsCode')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<BR>
<button type="submit" class="button big" name="login-button" value="<?= Url::to(['/login'])?>">Войти</button>
<?php ActiveForm::end(); ?>

