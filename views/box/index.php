<?php

use app\models\Box;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BoxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box-index">

	<?php Pjax::begin(['id' => 'box-grid', 'timeout' => 240000, 'enablePushState' => false]); ?>
	<?= Html::button('Добавить', [
		'class' => 'btn btn-success btn-show-modal-form',
		'title' => 'Добавить',
		'data-action-url' => Url::to('/box/edit'),
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
            'time_start',
            'time_end',

	        [
		        'class' => 'yii\grid\ActionColumn',
		        'template' => '{update}',
		        'contentOptions'=>['style'=> 'text-align: center'],
		        'buttons' => [
			        'update' => function ($url, $model, $key) {
				        /* @var $model Box */
				        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
					        'title' => 'Редактировать',
					        'class' => 'btn-show-modal-form',
					        'data-action-url' => Url::to(['/box/edit', 'id' => $model->id]),
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
				        /** @var $model Box */
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
