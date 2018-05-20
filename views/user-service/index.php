<?php

use app\models\Box;
use app\models\UserServiceBox;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserServiceBoxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="user_service-index">

	<?php Pjax::begin(['id' => 'box-grid', 'timeout' => 240000, 'enablePushState' => false]); ?>
	<?= Html::button('Добавить', [
		'class' => 'btn btn-success btn-show-modal-form',
		'title' => 'Добавить',
		'data-action-url' => Url::to('/user-service/edit'),
	]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'service_id',
				'content' => function ($data) {
					/** @var $data UserServiceBox */
					return $data->service->title;
				},
			],
			[
				'attribute' => 'user_id',
				'content' => function ($data) {
					/** @var $data UserServiceBox */
					return $data->user->phone;
				},
			],
			[
				'attribute' => 'box_id',
				'content' => function ($data) {
					/** @var $data UserServiceBox */
					return $data->box->title;
				},
			],
			[
				'attribute' => 'created_at',
				'filter' => \yii\jui\DatePicker::widget([
					'language' => 'ru',
					'dateFormat' => 'yyyy-MM-dd',
					'model' => $searchModel,
					'attribute' => 'created_at',
					'options' => ['class' => 'form-control', 'style' => 'width: 100px;'],
				]),
				'format' => 'html',
			],
			[
				'attribute' => 'date_start',
				'filter' => \yii\jui\DatePicker::widget([
					'language' => 'ru',
					'dateFormat' => 'yyyy-MM-dd',
					'model' => $searchModel,
					'attribute' => 'date_start',
					'options' => ['class' => 'form-control', 'style' => 'width: 100px;'],
				]),
				'format' => 'html',
			],
			'time_start',
			'time_end',
			'money_cost',
			'status',

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions'=>['style'=> 'text-align: center'],
				'buttons' => [
					'update' => function ($url, $model, $key) {
						/* @var $model UserServiceBox */
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
							'title' => 'Редактировать',
							'class' => 'btn-show-modal-form',
							'data-action-url' => Url::to(['/user-service/edit', 'id' => $model->id]),
						]);
					},
				],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete1}',
				'contentOptions'=>['style'=> 'text-align: center'],
				'buttons' => [
					'delete' => function ($url, $model) {
						/** @var $model UserServiceBox */
						return Html::a('<span class="glyphicon glyphicon-trash button-action-delete"></span>', 'javascript:;', [
							'title' => 'Удалить этот элемент',
							'class' => 'btn-show-confirm-form',
							'data-action-url' => Url::to(['delete', 'id' => $model->id]),
						]);
					},
				],
			],
		],
	]); ?>
	<?php Pjax::end(); ?>
</div>
