<?php

use app\models\Review;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="review-index">

	<?php Pjax::begin(['id' => 'review-grid', 'timeout' => 240000, 'enablePushState' => false]); ?>
	<?= GridView::widget([
		'layout' => "{summary}\n{pager}\n{items}\n{pager}\n{summary}",
		'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
		'options' => ['class' => ['table-report-detailed','grid-view']],
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'user_name',
			'user_email',
			'user_phone',
			'message',
			'created_at',
			[
				'attribute' => 'status',
				'format' => 'html',
				'filter' => \app\helpers\ReviewHelper::$statuses,
				'content' => function ($data) {
					/** @var $data Review */
					return \app\helpers\ReviewHelper::GetStatusText($data->status);
				},
				'contentOptions' => ['class' => 'text-middle button-status'],
			],


			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions'=>['style'=> 'text-align: center'],
				'buttons' => [
					'update' => function ($url, $model, $key) {
						/* @var Review $model */
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
							'title' => 'Редактировать',
							'class' => 'btn-show-modal-form',
							'data-action-url' => Url::to(['/review/edit', 'id' => $model->id]),
						]);
					},
				],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions'=>['style'=> 'text-align: center'],
				'buttons' => [
					'delete' => function ($url, $model) {
						/* @var Review $model */
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
