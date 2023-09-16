<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id автоинкремент
 * @property string $title название
 * @property string $title_short название
 * @property string $description описание
 * @property string $contacts
 * @property string $address
 * @property string $alias
 *
 * @property Box[] $boxes
 * @property News[] $news
 * @property Order[] $orders
 * @property Page[] $pages
 * @property Review[] $reviews
 * @property Service[] $services
 * @property User[] $users
 * @property UserBlocking[] $userBlockings
 * @property UserReview[] $userReviews
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_short', 'alias'], 'required'],
            [['description', 'contacts', 'address'], 'string'],
            [['title', 'title_short'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'contacts' => 'Contacts',
            'address' => 'Address',
            'alias' => 'Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoxes()
    {
        return $this->hasMany(Box::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserBlockings()
    {
        return $this->hasMany(UserBlocking::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserReviews()
    {
        return $this->hasMany(UserReview::className(), ['company_id' => 'id']);
    }
}
