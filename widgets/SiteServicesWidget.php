<?php

namespace app\widgets;

use app\models\Service;
use yii\bootstrap\Widget;

class SiteServicesWidget extends Widget
{
	public function run()
	{
		/** @var Service[] $items */
		$items = Service::find()->orderBy(['id'=>SORT_ASC])->all();
		return $this->render('siteServicesWidget', ['items'=>$items]);
	}
}