<?php

namespace app\models;

use app\components\CSmsClub;
use app\rbac\UserIdentity;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;

	private $_user = false;
	private $_userId = false;

	public $smsCode;
	public $smsPhone;

	private $_identity;
	public $errorIdentityCodes = [
		UserIdentity::ERROR_PASSWORD_INVALID => 'Неправильны пароль',
		UserIdentity::ERROR_USER_BLOCKED => 'Пользователь заблокирован',
	];

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['smsPhone'], 'required'],
			[['smsPhone'], 'string', 'max' => 25],
			[['smsCode'], 'string', 'max' => 10],
			[['smsCode'], 'safe'],
			//array('smsCode', 'authenticate', 'on' => 'phone'),
		];
	}
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'smsPhone' => 'Номер телефона',
			'smsCode' => 'Код подтвержения из SMS',
		];
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->smsCode = $this->smsCode;
			$this->_identity->smsPhone = $this->smsPhone;
			if (!$this->_identity->authenticate())
				$this->addError('error', $this->_identity->errorCode);
		}
	}

	public function sendPhoneSMS($userPhone = '', $userId = 0)
	{
		$hash = false;
		if (isset(\Yii::$app->params['CSmsClub'])) {

			if ($userId) {
				/** @var User $user */
				$user = User::find()->select(['phone', 'id'])->where(['id' => intval($userId)])->limit(1)->one();
				if (isset($user->phone) && $user->phone) $userPhone = $user->phone;
			} else {
				$userId = 0;
			}

			if ($userPhone) {
				$user = User::find()->select(['phone', 'id'])->where(['phone' => $userPhone])->limit(1)->one();
				if (isset($user->phone) && $user->phone) $userId = $user->id;
			}

			$userSmsQuery = new UserSmsQuery();
			if ($userId) $userSmsQuery->user_id = $userId;
			$userSmsQuery->phone = $userPhone;

			$lengthSMSCode = (isset(\Yii::$app->params['CSmsClub']['lengthSMSCode']) ? \Yii::$app->params['CSmsClub']['lengthSMSCode'] : 4);

			$userSmsQuery->code = CSmsClub::generateSMSCode($lengthSMSCode);
			$userSmsQuery->end_time = date("Y-m-d H:i:s", strtotime("+ 10 minutes"));
			$hash = $userSmsQuery->hash = md5(rand(1, 50) . $userSmsQuery->code . $userSmsQuery->end_time . rand(50, 100));
			$message = $userSmsQuery->code . "\n Deystvitelen do " . date("H:i d-m-Y", strtotime($userSmsQuery->end_time));
			if ($userSmsQuery->save()) {
				if (isset(\Yii::$app->params['CSmsClub']['testMode']) && \Yii::$app->params['CSmsClub']['testMode']) {
					// активирован тестовый режим - СМС не отсылаются
				} else {
					$smsClub = new CSmsClub();
					$smsClub->sendSms($userPhone, $message);
				}
			} else {
				#var_dump($authenticateCode->errors);
			}
		}

		return $hash;
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public	function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();

			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, 'Incorrect username or password.');
			}
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return bool whether the user is logged in successfully
	 */
	public function login()
	{
		//echo Yii::$app->security->generatePasswordHash('admin');die();
		if ($this->_identity === null) {
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->smsCode = $this->smsCode;
			$this->_identity->smsPhone = $this->smsPhone;
			if ($this->_userId = $this->_identity->authenticate()){
				return \Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
			}
			$this->addError('smsCode', $this->errorIdentityCodes[$this->_identity->errorCode]);
		}
		return false;
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	public	function getUser()
	{
		if ($this->_user === false) {
			$this->_user = User::findIdentity($this->_userId);
		}
		return $this->_user;
	}
}
