<?php
namespace app\helpers;

use app\models\Review;

/**
 * @package backend\helpers
 */
class ReviewHelper
{
	public static $statuses = [
		Review::STATUS_MODERATED => 'На модерации',
		Review::STATUS_CONFIRMED => 'Одобрен',
		Review::STATUS_CANCELED => 'Отвергнут',
	];
	/**
	 * @param $status
	 * @return string
	 */
	public static function GetStatusText($status)
	{
		$result = '';
		if (isset(self::$statuses[$status])) $result = self::$statuses[$status];
		return $result;
	}
}