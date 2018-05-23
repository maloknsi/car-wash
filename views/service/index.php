<?php

use app\models\Service;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\Service */
?>
<div class="service-index">
	<?php Pjax::begin(['id' => 'service-grid', 'timeout' => 240000, 'enablePushState' => false]); ?>
	<?= Html::button('Добавить', [
		'class' => 'btn btn-success btn-show-modal-form',
		'title' => 'Добавить',
		'data-action-url' => Url::to('/service/edit'),
	]); ?>

    <?= GridView::widget([
		'layout' => "{summary}\n{pager}\n{items}\n{pager}\n{summary}",
		'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
		'options' => ['class' => ['table-report-detailed','grid-view']],
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description:ntext',
            'time_processing',
            'money_cost',

	        [
		        'class' => 'yii\grid\ActionColumn',
		        'template' => '{update}',
		        'contentOptions'=>['style'=> 'text-align: center'],
		        'buttons' => [
			        'update' => function ($url, $model, $key) {
				        /* @var Service $model */
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
		        'template' => '{delete}',
		        'contentOptions'=>['style'=> 'text-align: center'],
		        'buttons' => [
			        'delete' => function ($url, $model) {
				        /* @var Service $model */
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
