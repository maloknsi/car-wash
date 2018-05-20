<?php

namespace app\controllers;

use app\models\Service;
use app\models\ServiceSearch;
use yii\web\NotFoundHttpException;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new ServiceSearch() : new Service();
	}
    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
