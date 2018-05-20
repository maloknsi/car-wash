<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\UserRoleRule;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;
		$auth->removeAll();
		$dashboard = $auth->createPermission('dashboard');
		$dashboard->description = 'Админ панель';
		$auth->add($dashboard);
		//Включаем обработчик
		$rule = new UserRoleRule();
		$auth->add($rule);
		//Добавляем роли
		$user = $auth->createRole('user');
		$user->description = 'Пользователь';
		$user->ruleName = $rule->name;
		$auth->add($user);

		$moder = $auth->createRole('operator');
		$moder->description = 'Оператор';
		$moder->ruleName = $rule->name;
		$auth->add($moder);

		//Добавляем потомков
		$auth->addChild($moder, $user);
		$auth->addChild($moder, $dashboard);
		$admin = $auth->createRole('admin');
		$admin->description = 'Админ';
		$admin->ruleName = $rule->name;
		$auth->add($admin);
		$auth->addChild($admin, $moder);
	}
}