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

		$dashboard = $auth->createPermission('p_admin');
		$dashboard->description = 'Админка';

		$auth->add($dashboard);

		$dashboard2 = $auth->createPermission('p_operator');
		$dashboard2->description = 'Операторская';

		$auth->add($dashboard2);

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

		$admin = $auth->createRole('admin');
		$admin->description = 'Админ';
		$admin->ruleName = $rule->name;

		$auth->add($admin);

		//Добавляем потомков
		$auth->addChild($moder, $user);
		$auth->addChild($moder, $dashboard2);
		$auth->addChild($admin, $dashboard);
		$auth->addChild($admin, $moder);
	}
}