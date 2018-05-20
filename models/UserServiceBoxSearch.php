<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserServiceSearch represents the model behind the search form of `app\models\UserService`.
 */
class UserServiceBoxSearch extends UserServiceBox
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'user_id', 'box_id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'date_start', 'time_start', 'time_end'], 'safe'],
            [['money_cost'], 'number'],
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
        $query = UserServiceBox::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
            'user_id' => $this->user_id,
            'box_id' => $this->box_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'date_start' => $this->date_start,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'money_cost' => $this->money_cost,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
