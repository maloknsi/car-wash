<?php

namespace app\models;
use UserService;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $time_processing
 * @property string $money_cost
 *
 * @property UserService[] $userServices
 */
class Service extends \yii\db\ActiveRecord
{
	public function formName(){
		return 's';
	}
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'time_processing', 'money_cost'], 'required'],
            [['description'], 'string'],
            [['time_processing'], 'safe'],
            [['money_cost'], 'number'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'time_processing' => 'Время выполнения',
            'money_cost' => 'Стоимость (Грн)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['service_id' => 'id']);
    }
}
