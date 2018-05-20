<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_blocking".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property int $phone
 * @property string $text
 * @property string $created_at
 * @property string $date_started
 * @property string $date_ended
 *
 * @property User $user
 */
class UserBlocking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_blocking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'phone'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'date_started', 'date_ended'], 'safe'],
            [['ip'], 'string', 'max' => 100],
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
            'ip' => 'Ip',
            'phone' => 'Phone',
            'text' => 'Text',
            'created_at' => 'Created At',
            'date_started' => 'Date Started',
            'date_ended' => 'Date Ended',
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
