<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $username
 * @property string $last_name
 * @property string $first_name
 * @property string $car_number
 * @property string $car_model
 * @property string $phone
 * @property string $auth_key
 * @property string $email_confirm_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $role
 *
 * @property UserBlocking[] $userBlockings
 * @property UserReview[] $userReviews
 * @property UserService[] $userServices
 */
class User extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;
	const ROLE_GUEST = 0;
	const ROLE_USER = 1;
	const ROLE_OPERATOR = 2;
	const ROLE_ADMIN = 4;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
			[['created_at', 'updated_at'], 'safe'],
			[['phone', 'role'], 'integer'],
			[['username', 'last_name', 'first_name', 'car_model'], 'string', 'max' => 50],
			[['car_number'], 'string', 'max' => 10],
			[['auth_key'], 'string', 'max' => 32],
			[['email_confirm_token', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
			[['user_name', 'user_email', 'user_phone'], 'requiredOneMoreFields'],
		];
	}

	public function requiredOneMoreFields($attribute_name, $params)
	{
		if (empty($this->phone) && empty($this->last_name) && empty($this->first_name) && empty($this->car_model) && empty($this->car_number)) {
			$this->addError($attribute_name, 'Не все данные даполнены');
			return false;
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'created_at' => 'Добавлен',
			'updated_at' => 'Обновлен',
			'username' => 'логин',
			'last_name' => 'Фамилия',
			'first_name' => 'Имя',
			'car_number' => 'Номер машины',
			'car_model' => 'Модель машины',
			'phone' => 'Телефон',
			'auth_key' => 'Auth Key',
			'email_confirm_token' => 'Email Confirm Token',
			'password_hash' => 'Password Hash',
			'password_reset_token' => 'Password Reset Token',
			'email' => 'Email',
			'status' => 'Статус',
			'role' => 'Доступ',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserBlockings()
	{
		return $this->hasMany(UserBlocking::class, ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserReviews()
	{
		return $this->hasMany(UserReview::class, ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserServices()
	{
		return $this->hasMany(UserService::class, ['user_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

	/**
	 * @return array user roles
	 */
	public static function getRoles()
	{
		return [
			self::ROLE_ADMIN => 'Админ',
			self::ROLE_USER => 'Пользователь',
			self::ROLE_OPERATOR => 'Оператор',
		];
	}

	/**
	 * @param $roleId int
	 * @return string
	 */
	public static function getRoleLabel($roleId)
	{
		return self::getRoles()[$roleId];
	}

	/**
	 * @return array user roles
	 */
	public static function getStatuses()
	{
		return [
			self::STATUS_ACTIVE => 'Активный',
			self::STATUS_DELETED => 'Заблокирован',
		];
	}

	/**
	 * @param $statusId int
	 * @return string
	 */
	public static function getStatusLabel($statusId)
	{
		return self::getStatuses()[$statusId];
	}

	/**
	 * @param $roles
	 * @return bool
	 */
	public static function checkAccess($roles)
	{
		$result = false;
		$roleIdentity = User::ROLE_GUEST;
		if (!Yii::$app->user->isGuest) {
			$roleIdentity = Yii::$app->user->identity->role;
		}
		if (in_array($roleIdentity, $roles)) {
			$result = true;
		}
		return $result;
	}
}
