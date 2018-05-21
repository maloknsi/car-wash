<?php

namespace app\widgets;

use app\models\Page;
use yii\bootstrap\Widget;

class SiteAboutWidget extends Widget
{
	public function run()
	{
		/** @var Page $content */
		$content = Page::find()->where(['alias'=>'about'])->limit(1)->one();
		return $this->render('siteAbout', ['content'=>$content]);
	}
}