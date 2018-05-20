<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property string $content
 */
class Page extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'page';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['alias'], 'required'],
			[['alias'], 'unique'],
			[['content'], 'string'],
			[['alias'], 'string', 'max' => 10],
			[['title'], 'string', 'max' => 100],
			[['alias'], 'unique'],
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
			'title' => 'Название страницы',
			'content' => 'Содержание страницы',
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
