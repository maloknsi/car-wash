<?php

namespace app\controllers;

use app\models\Box;
use app\models\BoxSearch;
use yii\web\NotFoundHttpException;

/**
 * BoxController implements the CRUD actions for Box model.
 */
class BoxController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new BoxSearch() : new Box();
	}

	/**
	 * Finds the Box model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Box the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Box::findOne($id)) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
