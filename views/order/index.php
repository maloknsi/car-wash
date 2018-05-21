<?php

use app\models\Order;
use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
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
		'layout' => "{summary}\n{pager}\n{items}\n{pager}\n{summary}",
		'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
		'options' => ['class' => ['table-report-detailed', 'grid-view']],
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'service_id',
				'content' => function ($data) {
					/** @var $data Order */
					return $data->service->title;
				},
			],
			[
				'attribute' => 'user_id',
				'content' => function ($data) {
					/** @var $data Order */
					return $data->user->phone;
				},
			],
			[
				'attribute' => 'box_id',
				'content' => function ($data) {
					/** @var $data Order */
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
			[
				'attribute' => 'time_start',
				'filter' => TimePicker::widget([
					'model' => $searchModel,
					'attribute' => 'time_start',
					'pluginOptions' => [
						'showSeconds' => false,
						'template' => false
					],
					'options' => [
						'readonly' => false,
					],
					'addonOptions' => [
						'asButton' => false,
						'buttonOptions' => ['class' => 'btn btn-info']
					]
				]),
				'headerOptions' => ['style' => 'min-width: 155px;'],
			],
			'time_start',
			'time_end',
			'money_cost',
			'status',

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'text-align: center'],
				'buttons' => [
					'update' => function ($url, $model, $key) {
						/* @var $model Order */
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
				'contentOptions' => ['style' => 'text-align: center'],
				'buttons' => [
					'delete' => function ($url, $model) {
						/** @var $model Order */
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
