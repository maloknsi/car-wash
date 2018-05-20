<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use yii\web\NotFoundHttpException;

/**
 * UserServiceController implements the CRUD actions for UserService model.
 */
class OrderController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new OrderSearch() : new Order();
	}

	/**
	 * Finds the UserService model based on its primary key value.
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
}
