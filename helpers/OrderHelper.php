<?php
namespace app\helpers;

use app\models\Order;
use app\models\Review;

/**
 * @package backend\helpers
 */
class OrderHelper
{
	public static $statuses = [
		Order::STATUS_BUSY => 'Забронировано',
		Order::STATUS_CANCEL => 'Отменен',
		Order::STATUS_SUCCESS => 'Выполнено',
	];
	/**
	 * @param $status
	 * @return string
	 */
	public static function getStatusText($status)
	{
		$result = '';
		if (isset(self::$statuses[$status])) $result = self::$statuses[$status];
		return $result;
	}

	/**
	 * @param $status
	 * @return string
	 */
	public static function getStatusTextForClient($status)
	{
		$result = self::getStatusText($status);
		if ($status == Order::STATUS_BUSY) $result = 'Отменить';
		return $result;
	}
	/**
	 * @param $timeStart
	 * @return string
	 */
	public static function getRoundUpTimeStart($timeStart)
	{
		$roundUpTimeStart = strtotime('+5 minutes', $timeStart);
		$roundUpMinutesRest = date('i',$roundUpTimeStart)%5;
		if ($roundUpMinutesRest != 0) {
			// если получилось меньше или больше x5 - округляем до х5 в большую сторону
			$roundUpTimeStart = strtotime('+'.(5 - $roundUpMinutesRest).' minutes',$roundUpTimeStart);
		}
		return date('H:i:\0\0', $roundUpTimeStart);
	}

	/**
	 * @param $model Order
	 * @return string
	 */
	public static function getStatusClassForClient($model)
	{
		/**
		 * @return string
		 **/
		switch ($model->status) {
			case Order::STATUS_BUSY:
				// можно отменить только если время бронирования больше текущего времени (+5минут)
				if (
					$model->date_start > date('Y-m-d') ||
					(date('Y-m-d') == $model->date_start && date('H:i', strtotime('+5 minutes')) <=  $model->time_start))
				{
					$result = "btn-show-confirm-form btn-danger";
				} else {
					$result = "btn-default disabled";
				}
				break;
			case Order::STATUS_SUCCESS:
				$result = "btn-success disabled";
				break;
			case Order::STATUS_CANCEL:
				$result = "btn-default disabled";
				break;
			default:
				$result = "btn-default disabled";
				break;
		}
		return $result;
	}
}