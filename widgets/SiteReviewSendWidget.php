<?php

namespace app\widgets;

use app\models\Review;
use yii\bootstrap\Widget;

class SiteReviewSendWidget extends Widget
{
	public function run()
	{
		$model = new Review();
		return $this->render('siteReviewSendForm', ['model'=>$model]);
	}
}