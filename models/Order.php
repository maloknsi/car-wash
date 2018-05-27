<?php

namespace app\models;

use app\helpers\OrderHelper;

/**
 * This is the model class for table "user_service".
 *
 * @property int $id
 * @property int $service_id
 * @property int $user_id
 * @property int $box_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $date_start
 * @property string $time_start
 * @property string $time_end
 * @property string $money_cost
 * @property int $status
 * @property \data $date_time_start
 *
 * @property Box $box
 * @property Service $service
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
	const STATUS_BUSY = 'busy';
	const STATUS_SUCCESS = 'success';
	const STATUS_CANCEL = 'cancel';

	public $date_time_start;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'user_id', 'box_id'], 'integer'],
            [['created_at', 'updated_at', 'date_start', 'time_start', 'time_end', 'date_time_start'], 'safe'],
            [['money_cost'], 'number'],
            [['status'], 'string'],

	        [['date_start'], 'checkAvailableDateTimeSubmit'],

	        [['service_id', 'box_id', 'date_start', 'time_start', 'time_end', 'money_cost', 'user_id'], 'required'],

            [['box_id'], 'exist', 'skipOnError' => true, 'targetClass' => Box::className(), 'targetAttribute' => ['box_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Услуга',
            'user_id' => 'Клиент',
            'box_id' => 'Бокс мойки',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'date_start' => 'Назначена дата',
            'time_start' => 'Время начала',
            'time_end' => 'Время окончания',
            'money_cost' => 'Стоимость',
            'status' => 'Статус',
            'date_time_start' => 'Время записи',
        ];
    }
	public function checkAvailableDateTimeSubmit($attribute_name, $params)
	{
		$return = true;
		// ошибка если выбранная дата старше текущей
		if (date('Y-m-d') > date('Y-m-d',strtotime($this->date_start))) {
			$this->addError('date_time_start', 'Нельзя бронировать прошедшую дату, выберите дату не старше ['.date('Y-m-d').']');
			$return =  false;
		}
		// ошибка если выбрана текущая дата но выбранное время больше текущего
		if ($return && (date('Y-m-d') == date('Y-m-d',strtotime($this->date_start)) && date('H:i')>date('H:i', strtotime($this->time_start)))) {
			$this->addError('date_time_start', 'Нельзя бронировать прошедшее время, выберите время не ранее ['.OrderHelper::getRoundUpTimeStart(strtotime('NOW')).']');
			$return =  false;
		}
		// Если с проверками все нормально - проверяем время работы бокса
		if ($return && $this->time_start < date('H:i', strtotime($this->box->time_start)) || $this->time_end > date('H:i', strtotime($this->box->time_end))){
			$this->addError('date_time_start', "Данное время [{$this->time_start} - {$this->time_end}] выходит за рамки времени работы бокса [{$this->box->time_start} - {$this->box->time_end}], выберите другое время");
			$return = false;
		}
		// Если с проверками на дату все нормально - проверяем занятость другими заказами
		if ($return){

			$orderBusyActiveRecord = Order::find()
				->where(['date_start'=>$this->date_start, 'box_id'=>$this->box_id, 'status'=>Order::STATUS_BUSY])
				->andWhere(['OR',['BETWEEN','time_start', $this->time_start, $this->time_end],['BETWEEN','time_end', $this->time_start, $this->time_end]]);
			if (!$this->isNewRecord){
				$orderBusyActiveRecord->andWhere(['<>','id',$this->id]);
			}
			$orderBusy = $orderBusyActiveRecord->limit(1)->one();
			/** @var Order $orderBusy */
			if ($orderBusy) {
				$this->addError('date_time_start', "Данное время уже зарезервировано другим заказом [{$orderBusy->time_start} - {$orderBusy->time_end}], выберите другое время");
				$return = false;
			}
		}
		return $return;
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBox()
    {
        return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

	/**
	 * @param null $dateStart
	 * @return array
	 */
	public static function getBoxTimetableArray($dateStart = null)
	{
		if (!$dateStart) $dateStart = date('Y-m-d');
		$boxesArray = [];
		/** @var Box[] $boxes */
		$boxes = Box::find()->all();
		foreach ($boxes as $box){
			$boxesArray[$box->id]['title'] = $box->title;
			$boxesArray[$box->id]['date_start'] = $dateStart;
			$boxOrdersArray = [];
			/** @var Order[] $boxOrders */
			$boxOrders = Order::find()->where(['box_id'=>$box->id, 'date_start'=>$dateStart, 'status'=>Order::STATUS_BUSY])->orderBy(['time_start'=>SORT_ASC])->all();
			// начало записи - начало работы бокса либо текущее время +5минут с округлением до 5 минут в большую сторону
			$orderTimeStart = $box->time_start;
			if ($dateStart == date('Y-m-d') && date('H:i:s') > $box->time_start){
				$orderTimeStart = OrderHelper::getRoundUpTimeStart(strtotime('NOW'));
			}
			$orderTimeEnd = $box->time_end;
			foreach ($boxOrders as $boxOrder){
				// добавляем пустую запись если есть свободное время от начала работы бокса до времени заказа
				if ($boxOrder->time_start > $orderTimeStart) {
					$boxOrdersArray[] = [
						'time_start' => date("H:i", strtotime($orderTimeStart)),
						'time_end' => date("H:i", strtotime($boxOrder->time_start))
					];
				}
				$orderTimeStart = OrderHelper::getRoundUpTimeStart(strtotime($boxOrder->time_end));
				// добавляем запись уже существующего заказа
				$boxOrdersArray[] = [
					'order_id' => $boxOrder->id,
					'date_start' => date("Y-m-d", strtotime($boxOrder->date_start)),
					'time_start' => date("H:i", strtotime($boxOrder->time_start)),
					'time_end' => date("H:i", strtotime($boxOrder->time_end)),
					'money_cost' => $boxOrder->money_cost,
					'user_id' => $boxOrder->user_id,
					'service_id' => $boxOrder->service_id,
					'status' => $boxOrder->status,
				];
			}
			// добавляем пустую запись если есть свободное время от окончания последнего заказа до окончания работы бокса
			// данное условеи на удивление правильно сработает и для бокса без заказов
			if ($orderTimeStart != $orderTimeEnd && $orderTimeEnd > $orderTimeStart) {
				$boxOrdersArray[] = [
					'time_start' => date("H:i", strtotime($orderTimeStart)),
					'time_end' => date("H:i", strtotime($orderTimeEnd))
				];
			}
			$boxesArray[$box->id]['timetable'] = $boxOrdersArray;
		}
		return $boxesArray;
	}
}
