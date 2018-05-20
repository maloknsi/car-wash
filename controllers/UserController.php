<?php

namespace app\controllers;

use app\models\UserSearch;
use app\models\User;
use yii\web\NotFoundHttpException;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends CAdminController
{
	public function getNewModel($isModelSearch = false)
	{
		return $isModelSearch ? new UserSearch() : new User();
	}
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Не найдена запись в базе данных');
    }
	/**
	 * @param User $model
	 * @return bool
	 */
	public function beforeModelSave($model)
	{
		if ($model->id){
			$model->generateAuthKey();
			$model->setPassword(rand(0,100));
		}
		return true;
	}

}
