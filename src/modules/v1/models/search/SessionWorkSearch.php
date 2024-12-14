<?php

namespace app\modules\v1\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\SessionWork;

/**
 * SessionWorkSearch represents the model behind the search form of `app\modules\v1\models\SessionWork`.
 */
class SessionWorkSearch extends SessionWork
{
    public function fields()
    {
        return [
            "id",
            "report",
            "filename",
            "is_session_current",
            "created_at" => function () {
                return date("H:i d/m", strtotime($this->created_at));
            },
            "created_at_int" => function () {
                return strtotime($this->created_at);
            },
            "updated_at"
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'is_session_current', 'type'], 'integer'],
            [['report', 'filename', 'data', 'created_at', 'updated_at'], 'safe'],
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
        $query = self::find();

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
            'created_by' => $this->created_by,
            'is_session_current' => $this->is_session_current,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'report', $this->report])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
