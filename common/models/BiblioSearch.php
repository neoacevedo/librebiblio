<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Biblio;

/**
 * BiblioSearch represents the model behind the search form about `common\models\Biblio`.
 */
class BiblioSearch extends Biblio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_userid', 'material_cd', 'collection_cd'], 'integer'],
            [['created_at', 'updated_at', 'call_nmbr1', 'call_nmbr2', 'call_nmbr3', 'title', 'title_remainder', 'responsibility_stmt', 'author', 'topic1', 'topic2', 'topic3', 'topic4', 'topic5', 'opac_flg'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Biblio::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_userid' => $this->updated_userid,
            'material_cd' => $this->material_cd,
            'collection_cd' => $this->collection_cd,
        ]);

        $query->andFilterWhere(['like', 'call_nmbr1', $this->call_nmbr1])
            ->andFilterWhere(['like', 'call_nmbr2', $this->call_nmbr2])
            ->andFilterWhere(['like', 'call_nmbr3', $this->call_nmbr3])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_remainder', $this->title_remainder])
            ->andFilterWhere(['like', 'responsibility_stmt', $this->responsibility_stmt])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'topic1', $this->topic1])
            ->andFilterWhere(['like', 'topic2', $this->topic2])
            ->andFilterWhere(['like', 'topic3', $this->topic3])
            ->andFilterWhere(['like', 'topic4', $this->topic4])
            ->andFilterWhere(['like', 'topic5', $this->topic5])
            ->andFilterWhere(['like', 'opac_flg', $this->opac_flg]);

        return $dataProvider;
    }
}
