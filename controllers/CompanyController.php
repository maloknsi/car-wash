<?php

namespace app\controllers;

use app\models\Company;
use app\models\CompanySearch;
use yii\web\NotFoundHttpException;

class CompanyController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new CompanySearch() : new Company();
	}

	/**
	 * Finds the Box model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Company the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Company::findOne($id)) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
