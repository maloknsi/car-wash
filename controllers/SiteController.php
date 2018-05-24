<?php

namespace app\controllers;

use app\models\Order;
use app\models\Review;
use app\models\User;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;
use app\models\LoginForm;

class SiteController extends CController
{
	public function behaviors()
	{
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::class,
					'only' => ['index', 'get-reservation-box-form', 'set-reservation-box', 'get-my-reservation-form'],
					'rules' => [
						[
							'allow' => true,
							'actions' => ['index', 'get-reservation-box-form'],
							'roles' => [],
						],
						[
							'allow' => true,
							'actions' => ['set-reservation-box','get-my-reservation-form'],
							'roles' => ['@'],
						],
					],
				],
				[
					'class' => 'yii\filters\AjaxFilter',
					'only' => ['login', 'get-reservation-box-form', 'get-box-timetable', 'get-my-reservation-form'],
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
		#var_dump(Order::getBoxTimetableArray());die();
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
			if (Yii::$app->request->isAjax){
				$this->ajaxResult->error =  $exception->getMessage();
			} else {
				return $this->render('error', ['exception' => $exception]);
			}
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
						if (User::checkAccess([User::ROLE_ADMIN, User::ROLE_OPERATOR])){
							$this->ajaxResult->data = 'admin';
						}
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
	 * @return array
	 * @internal param null $date
	 */
	public function actionGetMyReservationForm()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Order::find()->where(['user_id'=>\Yii::$app->user->id])->orderBy(['date_start'=>SORT_DESC,'time_start'=>SORT_DESC]),
			'pagination' => [
				'pageSize' => 100,
			],
			'sort' => false
		]);
		return $this->renderAjax('/user/reservationBoxForm', ['orders' => $dataProvider]);
	}

	/**
	 * @return array
	 */
	public function actionGetReservationBoxForm()
	{
		$orderData = Yii::$app->getRequest()->get();
		$order = new Order();
		$order->load($orderData);
		$order->date_time_start = date('Y-m-d H:i', strtotime($order->date_start . ' ' . $order->time_start));
		$order->user_id = \Yii::$app->user->id;
		return $this->renderAjax('/order/reservationBoxForm', ['order' => $order,]);
	}
	/**
	 * @return array
	 */
	public function actionSetReservationBox()
	{
		$model = new Order();
		if ($model->load(Yii::$app->getRequest()->post())) {
			$model->user_id = \Yii::$app->user->id;
			$model->money_cost = $model->service->money_cost;
			$model->date_start = date('Y-m-d', strtotime($model->date_time_start));
			$model->time_start = date('H:i', strtotime($model->date_time_start));
			$model->time_end = date('H:i', strtotime($model->time_start) + strtotime($model->service->time_processing) - strtotime("00:00:00"));
			if (User::checkAccess([User::ROLE_USER])){
			}
			if ($model->validate() && $model->save()){
				$this->ajaxResult->data = "Спасибо, запись произведена #" . $model->id;
			}
		}
		$this->ajaxResult->error = $model->hasErrors() ? Html::errorSummary($model) : null;
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
}
