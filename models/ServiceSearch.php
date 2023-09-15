<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Service;

/**
 * ServiceSearch represents the model behind the search form of `app\models\Service`.
 */
class ServiceSearch extends Service
{
	public $date_time_start;
	public $service_time_start;
	public $service_date;
	public $box_id;
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'box_id'], 'integer'],
            [['money_cost'], 'number'],
            [['date_time_start'], 'string'],
	        [['title', 'description', 'time_processing', 'date_time_start'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Service::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // for select Box Available Services
	    if (false && $this->date_time_start){

	    	if (
	    		(date('Y-m-d') > date('Y-m-d', strtotime($this->date_time_start))) ||
			    (date('Y-m-d') == date('Y-m-d', strtotime($this->date_time_start)) && date('H:i')>date('H:i', strtotime($this->date_time_start)))
		    ){
			    // нет услуг для прошлой даты, прошлого времени
			    $query->where('0=1');
		    } else {
			    $this->service_time_start = date('H:i', strtotime($this->date_time_start));
			    $this->service_date = date('Y-m-d', strtotime($this->date_time_start));

			    $query->innerJoin('box',
				    "box.id = {$this->box_id}"
				    ." and box.time_start <= '{$this->service_time_start}'"
				    ." and CONVERT(box.time_end USING utf8) >= ADDTIME('{$this->service_time_start}', service.time_processing)"
			    );

			    $query->leftJoin('`order`',
				    "`order`.box_id = {$this->box_id} and `order`.date_start='{$this->service_date}' and `order`.status='".Order::STATUS_BUSY."' and ("
				    ."('{$this->service_time_start}' > `order`.time_start and '{$this->service_time_start}' < `order`.time_end)"
				    ." or "
				    ."(ADDTIME('{$this->service_time_start}', `service`.time_processing) > CONVERT(`order`.time_start USING utf8) and ADDTIME('{$this->service_time_start}', `service`.time_processing) < CONVERT(`order`.time_end USING utf8))"
				    ." or "
				    ."'{$this->service_time_start}' = `order`.time_start OR ADDTIME('{$this->service_time_start}', `service`.time_processing) = CONVERT(`order`.time_end USING utf8)"
				    .")"
			    );
			    $query->andWhere("`order`.id IS NULL");
		    }
	    }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'time_processing' => $this->time_processing,
            'money_cost' => $this->money_cost,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
