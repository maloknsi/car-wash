<?php

use app\models\Order;
use app\models\Service;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $orders app\models\Order[] */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="portlet-body">
	<div class="panel">
		<div class="panel panel-info">
			<div class="panel-heading">Ваши заказы</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<? Pjax::begin(['id' => 'my-services-timetable-pjax', 'timeout' => 7000, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
					<?= GridView::widget([
						'id' => 'my-services-timetable-grid',
						'layout' => "{items}\n{pager}\n{summary}",
						'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
						'options' => ['class' => ['table-report-detailed', 'grid-view']],
						'dataProvider' => $orders,
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
								'attribute' => 'box_id',
								'content' => function ($data) {
									/** @var $data Order */
									return $data->box->title;
								},
							],
							[
								'attribute' => 'date_start',
							],
							[
								'attribute' => 'time_start',
							],
							[
								'attribute' => 'time_end',
							],
							'money_cost',
							'status',
							[
								'class' => 'yii\grid\ActionColumn',
								'template' => '{delete}',
								'contentOptions' => ['style' => 'text-align: center'],
								'buttons' => [
									'delete' => function ($url, $model) {
										/** @var Order $model */
										return Html::a('<span class="glyphicon glyphicon-trash button-action-delete"></span>', 'javascript:;', [
											'title' => 'Отменить заказ',
											'class' => 'btn-show-confirm-form',
											'visible' => false,
											'data-action-url' => Url::to(['/order/delete', 'id' => $model->id]),
										]);
									},
								],
								'visibleButtons'=>[
									'delete'=> function($model){
										/** @var Order $model */
										return $model->status == Order::STATUS_BUSY;
									},
								]
							],
						],
					]); ?>
					<? Pjax::end(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<?= Html::button('Закрыть', ['class' => 'btn grey-mint', 'data-dismiss' => "modal"]); ?>
		</div>
	</div>
</div>
