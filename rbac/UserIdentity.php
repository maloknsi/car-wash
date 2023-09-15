<?php
namespace app\rbac;

use app\models\User;
use app\models\UserSmsQuery;
use yii\base\BaseObject;
use yii\db\Expression;
use yii\helpers\Html;
use yii\web\IdentityInterface;

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * @property integer $roleId
 * @property string $smsCode
 * @property string $smsPhone
 * @property string apiToken
 */
class UserIdentity extends BaseObject implements IdentityInterface
{
	const ERROR_NONE = 0;
	const ERROR_USERNAME_INVALID = 1;
	const ERROR_PASSWORD_INVALID = 2;
	const ERROR_USER_BLOCKED = 3;
	const ERROR_UNKNOWN_IDENTITY = 100;
	const ERROR_NO_PHONE = 200;
	public $id;
	public $username;
	public $password;
	public $authKey;
	public $accessToken;
	public $firstName;
	public $lastName;
	public $role;
	public $phone;

	private $_id;
	private $_roleId;

	private $_smsCode;
	private $_smsPhone;
	public $errorCode;

	public $forcedAuthorizationUser;

	/**
	 * @param int|string $id
	 * @return UserIdentity|null
	 */
	public static function findIdentity($id)
	{
		$user = User::find()->alias('t')->where(['t.id' => intval($id)])->one();
		if (isset($user)) {
			$model = new UserIdentity();
			$model->id = $user->id;
			$model->username = $user->email;
			$model->password = $user->password;
			$model->firstName = $user->firstname;
			$model->lastName = $user->lastname;
			$model->phone = $user->phone;
			$model->authKey = md5($model->id . "authKey" . $model->username . $model->password . $model->id);
			return $model;
		}

		return null;
	}

	/**
	 * @param mixed $token
	 * @param null $type
	 * @return UserIdentity|null
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		$user = User::find()->where('hash = :token AND active = 1',
			[':token' => Html::encode($token)])->one();
		if (isset($user)) {
			$model = new UserIdentity();
			$model->id = $user->id;
			$model->username = $user->email;
			$model->password = $user->password;
			$model->firstName = $user->firstname;
			$model->lastName = $user->lastname;
			$model->phone = $user->phone;
			$model->authKey = md5($model->id . "authKey" . $model->username . $model->password . $model->id);
			return $model;
		}

		return null;
	}


	public function authenticate()
	{
		$userId = 0;
		$this->errorCode = self::ERROR_NONE;
		if (!$this->smsCode || !$this->smsPhone) {
			$this->errorCode = self::ERROR_NO_PHONE;
		} else {
			/** @var UserSmsQuery $userSmsQuery */
			$userSmsQuery = UserSmsQuery::find()->where([
				'code' => $this->smsCode,
				'phone' => $this->smsPhone,
				'status' => UserSmsQuery::STATUS_ACTIVE,
			])
				->andWhere(['>', 'end_time',new Expression('NOW()')])
				->limit(1)->orderBy(['id' => SORT_DESC])->one();

			if (!$userSmsQuery) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			} else {
				UserSmsQuery::updateAll(['status' => UserSmsQuery::STATUS_USED], ['id' => $userSmsQuery->id]);
				if (isset($userSmsQuery->user)) {
					$userId = $userSmsQuery->user_id;
					if (!$userSmsQuery->user->status) {
						$this->errorCode = self::ERROR_USER_BLOCKED;
						$userId = 0;
					}
				} else {
					$user = new User();
					$user->phone = $this->smsPhone;
					$user->status = User::STATUS_ACTIVE;
					$user->save();
					$userId = $user->getPrimaryKey();
				}
			}
		}
		return $userId;
	}

	/**
	 * @return mixed
	 */
	public function getAuthKey()
	{
		return $this->authKey;
	}

	/**
	 * @param string $authKey
	 * @return bool
	 */
	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * @return integer
	 */
	public function getRoleId()
	{
		return $this->_roleId;
	}

	/**
	 * @return mixed
	 */
	public function getSmsCode()
	{
		return $this->_smsCode;
	}

	/**
	 * @param mixed $smsCode
	 */
	public function setSmsCode($smsCode)
	{
		$this->_smsCode = $smsCode;
	}

	/**
	 * @return mixed
	 */
	public function getSmsPhone()
	{
		return $this->_smsPhone;
	}

	/**
	 * @param mixed $smsPhone
	 */
	public function setSmsPhone($smsPhone)
	{
		$this->_smsPhone = $smsPhone;
	}
}