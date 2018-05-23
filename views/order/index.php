<?php

use app\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="order-index">

	<?php Pjax::begin(['id' => 'order-grid', 'timeout' => 240000, 'enablePushState' => false]); ?>
	<?= Html::button('Добавить', [
		'class' => 'btn btn-success btn-show-modal-form',
		'title' => 'Добавить',
		'data-action-url' => Url::to('/order/edit'),
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
				'filter' => kartik\date\DatePicker::widget([
					//http://demos.krajee.com/widget-details/datepicker
					'model' => $searchModel,
					'attribute' => 'created_at',
					'removeButton' => false,
					'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' => [
						'autoclose'=>true,
						'format' => 'yyyy-mm-dd'
					]
				]),
				'headerOptions' => ['style' => 'min-width: 155px;'],
			],
			[
				'attribute' => 'date_start',
				'filter' => kartik\date\DatePicker::widget([
					//http://demos.krajee.com/widget-details/datepicker
					'model' => $searchModel,
					'attribute' => 'date_start',
					'removeButton' => false,
					'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' => [
						'autoclose'=>true,
						'format' => 'yyyy-mm-dd'
					]
				]),
				'headerOptions' => ['style' => 'min-width: 155px;'],
			],
			[
				'attribute' => 'time_start',
				'filter' => \kartik\datetime\DateTimePicker::widget([
					//http://demos.krajee.com/widget-details/datetimepicker
					'model' => $searchModel,
					'attribute' => 'time_start',
					'removeButton' => false,
					'pickerButton' => ['icon' => 'time'],
					'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' => [
						'showMeridian'=>false,
						'template' => false,
						'autoclose'=>true,
						'format' => 'hh:ii',
					],
				]),
				'headerOptions' => ['style' => 'min-width: 155px;'],
			],
			[
				'attribute' => 'time_end',
				'filter' => \kartik\datetime\DateTimePicker::widget([
					//http://demos.krajee.com/widget-details/datetimepicker
					'model' => $searchModel,
					'attribute' => 'time_end',
					'removeButton' => false,
					'pickerButton' => ['icon' => 'time'],
					'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' => [
						'showMeridian'=>false,
						'template' => false,
						'autoclose'=>true,
						'format' => 'hh:ii',
					],
				]),
				'headerOptions' => ['style' => 'min-width: 155px;'],
			],
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
							'data-action-url' => Url::to(['edit', 'id' => $model->id]),
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
