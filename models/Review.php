<?php

namespace app\models;

use Yii;

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
			[['message'], 'required'],
			[['created_at'], 'safe'],
			[['user_name', 'user_email'], 'string', 'max' => 50],
			[['user_name', 'user_email', 'user_phone'], 'requiredOneMoreFields'],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['user_id' => 'id']],
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

	public function requiredOneMoreFields($attribute_name, $params)
	{
		if (empty($this->user_name) && empty($this->user_email) && empty($this->user_phone)) {
			$this->addError($attribute_name, 'Не все данные даполнены');
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
