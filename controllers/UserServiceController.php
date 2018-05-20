<?php

namespace app\controllers;

use app\models\UserServiceBox;
use app\models\UserServiceBoxSearch;
use yii\web\NotFoundHttpException;

/**
 * UserServiceController implements the CRUD actions for UserService model.
 */
class UserServiceController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new UserServiceBoxSearch() : new UserServiceBox();
	}

	/**
	 * Finds the UserService model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return UserServiceBox the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = UserServiceBox::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
