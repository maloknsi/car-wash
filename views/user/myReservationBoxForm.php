<?php

use app\helpers\OrderHelper;
use app\models\Order;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $orders app\models\Order[] */
/* @var $searchModel app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="portlet-body">
	<div class="panel">
		<div class="panel panel-info">
			<div class="panel-heading">Ваши заказы</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<?php Pjax::begin([
						'id' => 'my-services-timetable-pjax',
						'timeout' => 240000,
						'enableReplaceState'=>false,
						'enablePushState'=>false,
						'linkSelector'=>'a1',
						'clientOptions' => ['method' => 'POST'],
					]); ?>
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
								'label' => "Дата",
								'contentOptions' => ['style' => 'text-align: center'],
							],
							[
								'attribute' => 'time_start',
								'label' => "Начало",
								'contentOptions' => ['style' => 'text-align: center'],
							],
							[
								'attribute' => 'time_end',
								'label' => 'Конец',
								'contentOptions' => ['style' => 'text-align: center'],
							],
							[
								'attribute' => 'money_cost',
								'contentOptions' => ['style' => 'text-align: center'],
							],
							[
								'class' => 'yii\grid\ActionColumn',
								'template' => '{delete}',
								'contentOptions' => ['style' => 'text-align: center'],
								'buttons' => [
									'delete' => function ($url, $model) {
										/** @var Order $model */
										return Html::a(OrderHelper::GetStatusTextForClient($model->status),
											'javascript:;', [
												'title' => 'Статус заказа',
												'data-pjax' => false,
												'class' => 'btn btn-md col-md-12 ' . OrderHelper::GetStatusClassForClient($model),
												'data-action-url' => Url::to(['/order/delete', 'id' => $model->id]),
											]);
									},
								],
							],
						],
					]); ?>
					<?php Pjax::end(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<?= Html::button('Закрыть', ['class' => 'btn grey-mint btn-close', 'data-dismiss' => "modal"]); ?>
		</div>
	</div>
</div>
<script>
	$("document").ready(function(){
		$('#my-services-timetable-grid').parents('div#modal-form-ajax').addClass('reload-siteBoxesTimetable');
		if (!$('#btn-get_my_reservation_form').attr('form-loaded')){
			$('#btn-get_my_reservation_form').attr('form-loaded', true);
			$('#btn-get_my_reservation_form').attr('data-action-url', $('#btn-get_my_reservation_form').attr('data-action-url') + '?no-pjax=1');
		}
    });
</script>