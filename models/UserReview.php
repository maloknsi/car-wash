<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_review".
 *
 * @property int $id
 * @property int $user_id
 * @property int $phone
 * @property string $car_model
 * @property string $car_number
 * @property string $first_name
 * @property string $last_name
 * @property string $message
 * @property string $created_at
 *
 * @property User $user
 */
class UserReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'phone'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['car_model', 'first_name', 'last_name'], 'string', 'max' => 50],
            [['car_number'], 'string', 'max' => 10],
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
            'car_model' => 'Car Model',
            'car_number' => 'Car Number',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'message' => 'Text',
            'created_at' => 'Created At',
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
