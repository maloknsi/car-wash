<?php

namespace app\widgets;

use app\models\Page;
use yii\bootstrap\Widget;

class SiteContactsWidget extends Widget
{
	public function run()
	{
		/** @var Page $content */
		$content = Page::find()->where(['alias'=>'contacts'])->limit(1)->one();
		return $this->render('siteContacts', ['content'=>$content]);
	}
}