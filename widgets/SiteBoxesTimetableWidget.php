<?php

namespace app\widgets;

use app\models\Order;
use yii\bootstrap\Widget;

class SiteBoxesTimetableWidget extends Widget
{
	public function run()
	{
		$boxesTimetable = Order::getBoxTimetableArray();
		return $this->render('siteBoxesTimetable', ['boxesTimetable'=>$boxesTimetable]);
	}
}