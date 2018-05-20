<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property string $content
 * @property string $created_at
 */
class News extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'news';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['alias'], 'unique'],
			[['content'], 'string'],
			[['created_at'], 'safe'],
			[['alias'], 'string', 'max' => 50],
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
			'alias' => 'Алиас',
			'title' => 'Название',
			'content' => 'Содержание',
			'created_at' => 'Дата создания',
		];
	}

	public function behaviors()
	{
		return [
			[
				'class' => \app\components\SluggableBehavior::className(),
				'attribute' => 'title',
				'slugAttribute' => 'alias',
				'transliterator' => 'Russian-Latin/BGN; NFKD',
				//Set this to true, if you want to update a slug when source attribute has been changed
				'forceUpdate' => true,
				'ensureUnique' => true,
			],
		];
	}
}
