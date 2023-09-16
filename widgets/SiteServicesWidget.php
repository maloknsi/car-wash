<?php

namespace app\widgets;

use app\models\Service;
use yii\bootstrap\Widget;

class SiteServicesWidget extends Widget
{
    private $services = [
        1 => [],
        2 => [],
        3 => [],
    ];
	public function run()
	{
		/** @var Service[] $items */
		$items = Service::find()
            ->where(['company_id' => \Yii::$app->controller->company->id])
            ->orderBy(['menu_block'=>SORT_ASC,'sort' => SORT_ASC])->all();
        foreach ($items as $item){
            $this->services[$item->menu_block][] = $item;
        }
		return $this->render('services-main', ['items'=>$this->services]);
	}
}