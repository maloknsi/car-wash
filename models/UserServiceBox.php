<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_service".
 *
 * @property int $id
 * @property int $service_id
 * @property int $user_id
 * @property int $box_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $date_start
 * @property string $time_start
 * @property string $time_end
 * @property string $money_cost
 * @property int $status
 *
 * @property Box $box
 * @property Service $service
 * @property User $user
 */
class UserServiceBox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_service_box';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'box_id', 'date_start', 'time_start', 'time_end', 'money_cost'], 'required'],
            [['service_id', 'user_id', 'box_id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'date_start', 'time_start', 'time_end'], 'safe'],
            [['money_cost'], 'number'],
            [['box_id'], 'exist', 'skipOnError' => true, 'targetClass' => Box::className(), 'targetAttribute' => ['box_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
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
            'service_id' => 'Услуга',
            'user_id' => 'Клиент',
            'box_id' => 'Бокс мойки',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'date_start' => 'Назначена дата',
            'time_start' => 'Время начала',
            'time_end' => 'Время окончания',
            'money_cost' => 'Стоимость',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBox()
    {
        return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
