<?php
namespace app\controllers;

use app\models\User;
use app\components\AjaxResult;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

abstract class CController extends Controller
{
	/**
	 * @var array
	 * хлебные крошки
	 */
	public $breadcrumbs = [];

	/**
	 * @var array
	 * меню сайта
	 */
	public $menuItems = [];

	/**
	 * @var string
	 * название сайта
	 */
	public $title = 'NEXUS';

	/** @var $ajaxResult AjaxResult */
	public $ajaxResult;

	/**
	 * @return array
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				//'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * @param \yii\base\Action $action
	 * @return bool
	 */
	public function beforeAction($action)
	{
		#echo "<pre>";var_dump($this->behaviors());die();
		if (!Yii::$app->request->isAjax) {
			$this->initMenu();
		}
		return parent::beforeAction($action);
	}

	public function init()
	{
		if (Yii::$app->request->isAjax) {
			$this->ajaxResult = new AjaxResult();
		}
	}

	public function afterAction($action, $result)
	{
		if(Yii::$app->request->isAjax &&
			(!is_null($this->ajaxResult->data) || !is_null($this->ajaxResult->notify) || !is_null($this->ajaxResult->error))){
			return Json::encode($this->ajaxResult);
		}
		return parent::afterAction($action, $result);
	}
	/**
	 * Init menu - set menu and title
	 */
	public function initMenu()
	{
		if (!count($this->menuItems)){
			// init menu items
			$menuItems =[
				//'api-push'=> ['label' => 'Статистика Api Push', 'url' => ['api-push/index']],

				'control'=> [
					'label' => 'Управление', 'url' => 'javascript:;',
					'submenuOptions' => ['class' => 'sub-menu'],
					'items' => [
						['label' => 'Заказы', 'url' => ['/order']],
						['label' => 'Отзывы', 'url' => ['/review']],
						['label' => 'Новости', 'url' => ['/news']],
						['label' => 'Пользователи', 'url' => ['/user']],
					]
				],
				'config'=> [
					'label' => 'Настройки', 'url' => 'javascript:;',
					'submenuOptions' => ['class' => 'sub-menu'],
					'items' => [
						['label' => 'Страницы сайта', 'url' => ['/page']],
						['label' => 'Боксы', 'url' => ['/box']],
						['label' => 'Сервисы', 'url' => ['/service']],
					]
				],
			];
			// set menu items for users
			if (!Yii::$app->user->isGuest) {
				if (User::checkAccess([User::ROLE_OPERATOR])) {
					$this->menuItems['orders'] = ['label' => 'Заказы', 'url' => ['/order']];
				}
				if (User::checkAccess([User::ROLE_ADMIN])) {
					$this->menuItems['control'] = $menuItems['control'];
					$this->menuItems['config'] = $menuItems['config'];
				}
			}
			// set menu 'Login'
			if (!Yii::$app->user->isGuest) {
				$this->menuItems['authorization'] = [
					'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
					'url' => ['/site/logout'],
					'linkOptions' => ['data-method' => 'post']
				];
			} else {
				$this->menuItems['authorization'] = [
					'label' => 'Вход',
					'url' => '#',
					'linkOptions' => [
						'data-method' => 'post',
						'title' => 'Авторизация',
						'class' => 'btn-show-modal-form',
						'data-action-url' => Url::to(['/login']),
					]

				];
			}

			$traceRoute = [Yii::$app->requestedRoute];
			$menuName = $this->getMenuName($traceRoute);
			if ($menuName){
				$this->title = $menuName;
			}
		}
	}
	/**
	 * @param string $view
	 * @param array $params
	 * @return string
	 */
	public function render($view, $params = [])
	{
		# set last item breadcrumbs from title
		$this->breadcrumbs[] = $this->title;
		return parent::render($view, $params);
	}

	/**
	 * @param $url
	 * @param array $menuItems
	 * @return string
	 */
	public function getMenuName($url, $menuItems = [])
	{
		$result = '';
		if (!count($menuItems)){
			$menuItems = $this->menuItems;
		}
		foreach ($menuItems as $menuItem){
			if (isset($menuItem['items']) && $resultMenuItem = $this->getMenuName($url, $menuItem['items'])){
				$result = $resultMenuItem;
			} elseif (isset($menuItem['url']) && str_replace('/','',$menuItem['url']) == $url){
				$result = $menuItem['label'];
			}
		}
		return $result;
	}

}