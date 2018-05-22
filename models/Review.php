<?php

namespace app\models;

use Yii;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_name
 * @property string $user_email
 * @property int $user_phone
 * @property string $message
 * @property string $created_at
 * @property string  $status
 *
 * @property Review $user
 * @property Review[] $reviews
 */
class Review extends \yii\db\ActiveRecord
{
	const STATUS_MODERATED = "moderated";
	const STATUS_CONFIRMED = "confirmed";
	const STATUS_CANCELED = "canceled";

	public $required_one_of_many_fields = 1;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'review';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_id', 'user_phone'], 'integer'],
			[['message', 'status'], 'string'],
			[['user_name', 'user_email'], 'string', 'max' => 50],
			[['user_email'], 'email'],

			[['message', 'required_one_of_many_fields'], 'required'],

			[['required_one_of_many_fields'], 'requiredOneOfManyFields'],

			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['user_id' => 'id']],

			[['created_at', 'user_email'], 'safe'],

		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'user_name' => 'Имя пользвателя',
			'user_email' => 'Email пользователя',
			'user_phone' => 'Телефон пользователя',
			'message' => 'Отзыв',
			'created_at' => 'Время создания',
			'status' => 'Статус',
		];
	}
	public function requiredOneOfManyFields($attribute_name, $params)
	{
		if (empty($this->user_name) && empty($this->user_email) && empty($this->user_phone)) {
			$errorMessage = 'Необходимо заполнить хотя бы одно поле ("'
				.$this->attributeLabels()['user_name'].'", "'
				.$this->attributeLabels()['user_phone'].'", "'
				.$this->attributeLabels()['user_email'].'"'
				.')';
			(new RequiredValidator())->validateAttribute($this,'user_name');
			(new RequiredValidator())->validateAttribute($this,'user_phone');
			(new RequiredValidator())->validateAttribute($this,'user_email');
			$this->addError($attribute_name, $errorMessage);
			return false;
		}
		return true;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(Review::className(), ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getReviews()
	{
		return $this->hasMany(Review::className(), ['user_id' => 'id']);
	}

	/**
	 * @return array user roles
	 */
	public static function getStatuses()
	{
		return [
			self::STATUS_MODERATED => 'Активный',
			self::STATUS_CONFIRMED => 'Заблокирован',
			self::STATUS_CANCELED => 'Заблокирован',
		];
	}

}
