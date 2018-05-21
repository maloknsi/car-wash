<?php

namespace app\controllers;

use app\models\Review;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends CController
{
	public function behaviors()
	{
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::class,
					'only' => ['index'],
					'rules' => [
						[
							'allow' => true,
							'actions' => ['index'],
							'roles' => [],
						],
					],
				],
				[
					'class' => 'yii\filters\AjaxFilter',
					'only' => ['login'],
					'errorMessage' => 'Ошибка типа запорса (AJAX ONLY!)',
				],
			]
		);
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 *  Send review from user
	 * @return string
	 */
	public function actionSendReview()
	{
		$model = new Review();
		if ($model->load(Yii::$app->getRequest()->post())) {
				if ($model->validate() && $model->save()){
					$this->ajaxResult->data = "Ваше сообщение отправлено на модерацию";
				}
		}
		$this->ajaxResult->error = $model->hasErrors() ? Html::errorSummary($model) : null;
	}

	/**
	 *  Send review from user [validate]
	 * @return string
	 */
	public function actionSendReviewValidate()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$model = new Review;
		if (Yii::$app->getRequest()->isPost && $model->load(Yii::$app->getRequest()->post())) {
			return ActiveForm::validate($model);
		}
	}

	/**
	 * Displays error page.
	 *
	 * @return string
	 */
	public function actionErrorPage()
	{
		$this->layout = 'admin';
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception]);
		}
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		$model = new LoginForm();
		if (Yii::$app->request->isPost){
			if ($model->load(Yii::$app->request->post()) && $model->validate()) {
				$model->smsPhone = str_replace([' ' , '(' , ')', '-', '+'] , '' , $model->smsPhone);
				if ($model->smsCode){
					if ($model->login()) {
						$this->ajaxResult->data = Yii::$app->user->identity->username;
					}
				} else {
					$this->ajaxResult->notify =  'Пароль подтверждения отправлен на телефон ' . $model->smsPhone;
					$model->sendPhoneSMS($model->smsPhone);
				}
			}
			//return ActiveForm::validate($model);
			$this->ajaxResult->error = $model->hasErrors() ? Html::errorSummary($model, ['header'=>'']) : null;

		} else {
			return $this->renderAjax('login', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
		]);
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}
}
