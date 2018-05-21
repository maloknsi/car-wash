<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_sms_query".
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $code
 * @property string $hash
 * @property string $created_at
 * @property string $end_time
 * @property string $status
 *
 * @property User $user
 */
class UserSmsQuery extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = "active";
	const STATUS_DISABLED = "disabled";
	const STATUS_USED = "used";

	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_sms_query';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'phone'], 'integer'],
            [['created_at', 'end_time'], 'safe'],
            [['status'], 'string'],
            [['code'], 'string', 'max' => 10],
            [['hash'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Phone',
            'code' => 'Code',
            'hash' => 'Hash',
            'created_at' => 'Created At',
            'end_time' => 'End Time',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
