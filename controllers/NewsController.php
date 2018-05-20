<?php

namespace app\controllers;

use app\models\News;
use app\models\NewsSearch;
use yii\web\NotFoundHttpException;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new NewsSearch() : new News();
	}

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
