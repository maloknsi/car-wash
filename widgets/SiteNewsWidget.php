<?php

namespace app\widgets;

use app\models\News;
use yii\bootstrap\Widget;

class SiteNewsWidget extends Widget
{
	public function run()
	{
		/** @var News[] $items */
		$items = News::find()->limit(5)->orderBy(['id'=>SORT_DESC])->all();
		return $this->render('siteNews', ['items'=>$items]);
	}
}