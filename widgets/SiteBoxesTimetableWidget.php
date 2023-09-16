<?php

namespace app\widgets;

use app\models\Order;
use yii\bootstrap\Widget;

class SiteBoxesTimetableWidget extends Widget
{
	public function run()
	{
		return $this->render('boxes-timetable', [
            'boxesTimetable'=>Order::getBoxTimetableArray(\Yii::$app->getRequest()->get('date_start',date('Y-m-d')))
        ]) ;
	}
}