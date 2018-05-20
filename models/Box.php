<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "box".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $time_start
 * @property string $time_end
 *
 * @property UserService[] $userServices
 */
class Box extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'box';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'time_start', 'time_end'], 'required'],
            [['description'], 'string'],
            [['time_start', 'time_end'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'time_start' => 'Начало работы',
            'time_end' => 'Окончание работы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['box_id' => 'id']);
    }
}
