<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BiblioStatusHistory;

/**
 * BiblioStatusHistorySearch represents the model behind the search form of `common\models\BiblioStatusHistory`.
 * @property Member $mbr
 */
class BiblioStatusHistorySearch extends BiblioStatusHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bibid', 'copyid', 'mbr_id'], 'integer'],
            [['status_cd', 'created_at', 'updated_at', 'due_back_dt'], 'safe'],
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
        $query = BiblioStatusHistory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
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
            'bibid' => $this->bibid,
            'copyid' => $this->copyid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'due_back_dt' => $this->due_back_dt,
            'mbr_id' => $this->mbr_id,
        ]);

        $query->andFilterWhere(['like', 'status_cd', $this->status_cd]);

        return $dataProvider;
    }
}
