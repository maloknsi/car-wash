<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends CAdminController
{
	public function behaviors()
	{
		return
			[
				'access' => [
					'class' => AccessControl::class,
					'rules' => [
						[
							'actions' => ['index' ,'edit','validate','save','delete'],
							'allow' => true,
							'roles' => ['operator'],
						],
					],
				],
				[
					'class' => 'yii\filters\AjaxFilter',
					'only' => ['delete'],
					'errorMessage' => 'Ошибка типа запорса (AJAX ONLY!)',
				],
			];
	}

	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new OrderSearch() : new Order();
	}

	/**
	 * Finds the Order model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Order the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Order::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
	/**
	 * Deletes an existing model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		Order::updateAll(['status'=>Order::STATUS_CANCEL],['id'=>$id]);
		$this->ajaxResult->data = "Заказ отменен";
	}
}
