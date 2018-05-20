<?php
namespace app\helpers;

use app\models\Review;

/**
 * Class Comments
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
	/**
	 * @param $status string
	 * @return string
	 */
	public static function GetStatusButton($status)
	{
		/**
		 * @var $comment Review
		 * @return string
		 **/

		switch ($status) {
			case Review::STATUS_MODERATED:
				$result = '<i class="button-action-moderated fa fa-eye-slash blue" title="На модерации"></i>';
				break;
			case Review::STATUS_CONFIRMED:
				$result = '<i class="button-action-confirmed fa fa-check-circle" title="Одобрен"></i>';
				break;
			case Review::STATUS_CANCELED:
				$result = '<i class="button-action-canceled fa fa-times-circle" title="Отвергнут"></i>';
				break;
			default:
				$result = '';
				break;
		}
		return $result;
	}

	/**
	 * @param $status int
	 * @return string
	 */
	public static function GetStatusClass($status)
	{
		/**
		 * @var $comment Review
		 * @return string
		 **/
		switch ($status) {
			case Review::STATUS_MODERATED:
				$result = "hidden";
				break;
			case Review::STATUS_CONFIRMED:
				$result = "confirmed";
				break;
			case Review::STATUS_CANCELED:
				$result = "canceled";
				break;
			default:
				$result = "";
				break;
		}
		return $result;
	}

	/**
	 * @param $text
	 * @param int $limit
	 * @return string
	 */
	public static function GetShortText($text, $limit=50)
	{
		$result = $text;

		if (mb_strlen($text)>$limit){
			$result  = mb_substr(htmlentities($text),0,$limit,'UTF-8').'...';
		}
		return ($result);
	}
}