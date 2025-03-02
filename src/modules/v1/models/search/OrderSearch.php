<?php

namespace app\modules\v1\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\modules\v1\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'device_id', 'package_id', 'status'], 'integer'],
            [['expired_at', 'type', 'provider_code', 'created_at', 'customer', 'provider_note', 'updated_at'], 'safe'],
            [['price'], 'number'],
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
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
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
            'device_id' => $this->device_id,
            'package_id' => $this->package_id,
            'status' => $this->status,
            'expired_at' => $this->expired_at,
            'created_at' => $this->created_at,
            'price' => $this->price,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'provider_code', $this->provider_code])
            ->andFilterWhere(['like', 'customer', $this->customer])
            ->andFilterWhere(['like', 'provider_note', $this->provider_note]);

        return $dataProvider;
    }
}
