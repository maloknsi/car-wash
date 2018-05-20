<?php
namespace app\controllers;

use app\models\User;
use app\components\AjaxResult;
use Yii;
use yii\helpers\BaseVarDumper;
use yii\helpers\Json;
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

			$menuItems =[
				'api-push'=> ['label' => 'Статистика Api Push', 'url' => ['api-push/index']],

				'control'=> [
					'label' => 'Управление', 'url' => 'javascript:;',
					'submenuOptions' => ['class' => 'sub-menu'],
					'items' => [
						['label' => 'Заказы', 'url' => ['/user-service']],
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
			// create menu items
			if (!Yii::$app->user->isGuest) {

				if (User::checkAccess([User::ROLE_ADMIN,User::ROLE_USER])) {
					$this->menuItems['task-cron'] = $menuItems['task-cron'];
				}
				if (User::checkAccess([User::ROLE_ADMIN])) {
					$this->menuItems['task-soap'] = $menuItems['task-soap'];
					$this->menuItems['task-report'] = $menuItems['task-report'];
					$this->menuItems['api-push'] = $menuItems['api-push'];
					$this->menuItems['config'] = $menuItems['config'];
				}
			}
			$this->menuItems['control'] = $menuItems['control'];
			$this->menuItems['config'] = $menuItems['config'];
			if (!Yii::$app->user->isGuest) {
				$this->menuItems['authorization'] = [
					'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
					'url' => ['/site/logout'],
					'linkOptions' => ['data-method' => 'post']
				];
			} else {
				$this->menuItems['authorization'] = [
					'label' => 'Вход',
					'url' => ['/site/login'],
					'linkOptions' => ['data-method' => 'post']
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