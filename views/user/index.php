<?php

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\User */
?>
<div class="user-index">
    <?php Pjax::begin(['id' => 'user-grid', 'timeout' => 240000, 'enablePushState' => false]); ?>
	<?= Html::button('Добавить', [
		'class' => 'btn btn-success btn-show-modal-form',
		'title' => 'Добавить',
		'data-action-url' => Url::to('/user/edit'),
	]); ?>
    <?= GridView::widget([
	    'layout' => "{summary}\n{pager}\n{items}\n{pager}\n{summary}",
	    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
	    'options' => ['class' => ['table-report-detailed','grid-view']],
        'dataProvider' => $dataProvider,
	    'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

	        'phone',
	        [
		        'attribute' => 'role',
		        'content' => function ($data) {	return User::getRoleLabel($data->role);},
		        'filter' => Html::activeDropDownList(
			        $searchModel,
			        'role',
			        ArrayHelper::merge(array('' => ''), User::getRoles()),
			        ['class' => 'form-control']
		        ),
		        'contentOptions'=>['style'=>'min-width: 125px;']
	        ],
	        'last_name',
	        'first_name',
	        'car_number',
	        'car_model',
	        [
		        'attribute' => 'status',
		        'content' => function ($data) {	return User::getStatusLabel($data->status);},
		        'filter' => Html::activeDropDownList(
			        $searchModel,
			        'status',
			        ArrayHelper::merge(array('' => ''), User::getStatuses()),
			        ['class' => 'form-control']
		        ),
		        'contentOptions'=>['style'=>'min-width: 155px;']
	        ],

	        'created_at',

	        [
		        'class' => 'yii\grid\ActionColumn',
		        'template' => '{update}',
		        'contentOptions'=>['style'=> 'text-align: center'],
		        'buttons' => [
			        /** @var User $model */
			        'update' => function ($url, $model, $key) {
				        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
					        'title' => 'Редактировать',
					        'class' => 'btn-show-modal-form',
					        'data-action-url' => Url::to(['/user/edit', 'id' => $model->id]),
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
				        /** @var User $model */
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
