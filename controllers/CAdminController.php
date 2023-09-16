<?php
namespace app\controllers;

use app\components\AjaxResult;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


abstract class CAdminController extends CController
{
	public $layout = 'admin';

	public function behaviors()
	{
		return [
				'access' => [
					'class' => AccessControl::class,
					'rules' => [
						[
							'actions' => ['index' ,'edit','validate','save','delete','logout'],
							'allow' => true,
							'roles' => ['admin'],
						],
					],
				],
				[
					'class' => 'yii\filters\AjaxFilter',
					'only' => ['edit','validate','save','delete'],
					'errorMessage' => 'Ошибка типа запорса (AJAX ONLY!)',
				],
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['post'],
					],
				],
			];
	}

    public function init()
    {
    }
	/**
	 * @param bool $isModelSearch
	 * @return ActiveDataProvider | ActiveRecord
	 */
	public function getNewModel($isModelSearch = false)
	{
		return null;
	}

	/**
	 * Finds the model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ActiveRecord the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		return null;
	}
	/**
	 * Lists all models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$this->breadcrumbs[] = 'Админка';
		$searchModel = $this->getNewModel(true);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	/**
	 * return form for for edit model create.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @param int
	 * @return mixed
	 */
	public function actionEdit($id = null)
	{
		$model = $id ? $this->findModel(intval($id)) : $this->getNewModel();
		return $this->renderAjax('form', [
			'model' => $model
		]);
	}
	/**
	 * Ajax Validate model.
	 * @param $id
	 * @return mixed
	 */
	public function actionValidate($id = null)
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$model = $id ? $this->findModel(intval($id)) : $this->getNewModel();
		if (Yii::$app->getRequest()->isPost && $model->load(Yii::$app->getRequest()->post())) {
			return ActiveForm::validate($model);
		}
	}

	/**
	 * @return bool
	 */
	public function beforeModelSave($model)
	{
		return true;
	}
	/**
	 * Save model.
	 * @param $id
	 * @return mixed
	 */
	public function actionSave($id = null)
	{
		$model = $id ? $this->findModel(intval($id)) : $this->getNewModel();
		if ($model->load(Yii::$app->getRequest()->post())) {
			if ($this->beforeModelSave($model)){
				if ($model->validate() && $model->save()){
					$this->ajaxResult->data = "Изменения успешно сохранены #" . $model->id;
				}
			}
		}
		$this->ajaxResult->error = $model->hasErrors() ? Html::errorSummary($model) : null;
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
		//Yii::$app->response->format = Response::FORMAT_JSON;
		$model = $this->findModel($id);
		$model->delete();
		$this->ajaxResult->data = "Удалено #" . $id;
	}

}