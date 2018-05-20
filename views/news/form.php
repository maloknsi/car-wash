<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
	'id' => 'news-form',
	'enableAjaxValidation' => true,
	'enableClientValidation' => false,
	'action' => ['save', 'id' => $model->id],
	'validationUrl' => ['validate', 'id' => $model->id],
	'options' => ['enctype' => 'multipart/form-data', 'class' => 'modal-active-form'],
]); ?>
<div class="portlet-body">
	<div class="panel">
		<div class="panel panel-info">
			<div class="panel-heading">Описание новости</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-xs-12">
					<?= $form->field($model, 'content')->widget(CKEditor::className(),[
						'editorOptions' => [
							'preset' => 'standard', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
							'inline' => false, //по умолчанию false
						],
					]); ?>
				</div>
			</div>
		</div>
		<div class="panel  panel-danger">
			<div class="panel-heading">Управление новостью</div>
			<div class="panel-body">
				<div class="col-xs-6">
					<?= $form->field($model, 'alias')->textInput() ?>
				</div>
				<div class="col-xs-6">
					<?= $form->field($model, 'created_at')->textInput(['disabled' => true]) ?>
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
			<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['value' => Url::to(['create']), 'title' => 'Подтвердить действие', 'class' => 'showModalButton btn btn-success']); ?>
			<?= Html::button('Закрыть', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
