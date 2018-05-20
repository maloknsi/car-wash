<?php

use app\models\News;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box-index">

	<?php Pjax::begin(['id' => 'box-grid', 'timeout' => 240000, 'enablePushState' => false]); ?>
	<?= Html::button('Добавить', [
		'class' => 'btn btn-success btn-show-modal-form',
		'title' => 'Добавить',
		'data-action-url' => Url::to('/news/edit'),
	]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'title',
			'alias',
			'content:html',
			'created_at',

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions'=>['style'=> 'text-align: center'],
				'buttons' => [
					'update' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
							/* @var $model News */
							'title' => 'Редактировать',
							'class' => 'btn-show-modal-form',
							'data-action-url' => Url::to(['edit', 'id' => $model->id]),
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
						/** @var $model News */
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
