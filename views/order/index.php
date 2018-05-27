<?php

use app\helpers\OrderHelper;
use app\models\Order;
use faryshta\widgets\JqueryClockPicker;
use yii\helpers\ArrayHelper;
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
				'filter' => Html::activeDropDownList(
					$searchModel,
					'service_id',
					ArrayHelper::merge(array('' => ''), ArrayHelper::map(\app\models\Service::find()->asArray()->all(), 'id', 'title')),
					['class' => 'form-control']
				),
				'headerOptions' => ['style' => 'min-width: 195px;'],
			],
			[
				'attribute' => 'user_id',
				'content' => function ($data) {
					/** @var $data Order */
					return $data->user->phone;
				},
				'headerOptions' => ['style' => 'min-width: 195px;'],
			],
			[
				'attribute' => 'box_id',
				'content' => function ($data) {
					/** @var $data Order */
					return $data->box->title;
				},
				'filter' => Html::activeDropDownList(
					$searchModel,
					'box_id',
					ArrayHelper::merge(array('' => ''), ArrayHelper::map(\app\models\Box::find()->asArray()->all(), 'id', 'title')),
					['class' => 'form-control']
				),
				'headerOptions' => ['style' => 'min-width: 135px;'],

			],
			[
				'attribute' => 'created_at',
				'filter' => \yii\jui\DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'created_at',
					'dateFormat' => 'yyyy-MM-dd',
					'options' => [
						'class' => 'form-control'
					]
				]),
				'headerOptions' => ['style' => 'min-width: 150px;'],
			],
			[
				'attribute' => 'date_start',
				'filter' => \yii\jui\DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'date_start',
					'dateFormat' => 'yyyy-MM-dd',
					'options' => [
						'class' => 'form-control'
					]
				]),
				'headerOptions' => ['style' => 'min-width: 130px;'],
				'contentOptions' => ['style' => 'text-align: center'],
			],
			[
				'attribute' => 'time_start',
				'filter' => JqueryClockPicker::widget([
					'model' => $searchModel,
					'attribute' => 'time_start',
					'clientOptions' => [
						'autoclose' => true,
					],
				]),
				'content' => function ($data) {
					/** @var $data Order */
					return date('H:i', strtotime($data->time_start));
				},
				'contentOptions' => ['style' => 'text-align: center'],
				'headerOptions' => ['style' => 'min-width: 115px;'],
			],
			[
				'attribute' => 'time_end',
				'filter' => JqueryClockPicker::widget([
					'model' => $searchModel,
					'attribute' => 'time_end',
					'clientOptions' => [
						'autoclose' => true,
					],
				]),
				'content' => function ($data) {
					/** @var $data Order */
					return date('H:i', strtotime($data->time_start));
				},
				'contentOptions' => ['style' => 'text-align: center'],
				'headerOptions' => ['style' => 'min-width: 115px;'],
			],
			'money_cost',
			[
				'attribute' => 'status',
				'content' => function ($data) {	return OrderHelper::getStatusText($data->status);},
				'filter' => Html::activeDropDownList(
					$searchModel,
					'status',
					ArrayHelper::merge(array('' => ''), OrderHelper::$statuses),
					['class' => 'form-control']
				),
				'headerOptions'=>['style'=>'min-width: 125px;']
			],
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
		],
	]); ?>
	<?php Pjax::end(); ?>
</div>
