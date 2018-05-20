<?php

namespace app\controllers;

use Yii;
use app\models\Review;
use app\models\ReviewSearch;
use app\controllers\CAdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new ReviewSearch() : new Review();
	}

	/**
	 * Finds the Review model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Review the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Review::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
