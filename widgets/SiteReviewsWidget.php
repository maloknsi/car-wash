<?php

namespace app\widgets;

use app\models\Review;
use yii\bootstrap\Widget;

class SiteReviewsWidget extends Widget
{
	public function run()
	{
		/** @var Review $items */
		$items = Review::find()->where(['status'=>Review::STATUS_CONFIRMED])->limit(5)->orderBy(['id'=>SORT_DESC])->all();
		return $this->render('siteReviews', ['items'=>$items]);
	}
}