<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BiblioField;

/**
 * BiblioFieldSearch represents the model behind the search form of `common\models\BiblioField`.
 */
class BiblioFieldSearch extends BiblioField
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'fieldid', 'tag'], 'integer'],
            [['ind1_cd', 'ind2_cd', 'subfield_cd', 'field_data'], 'safe'],
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
        $query = BiblioField::find();

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
            'bibid' => $this->bibid,
            'fieldid' => $this->fieldid,
            'tag' => $this->tag,
        ]);

        $query->andFilterWhere(['like', 'ind1_cd', $this->ind1_cd])
            ->andFilterWhere(['like', 'ind2_cd', $this->ind2_cd])
            ->andFilterWhere(['like', 'subfield_cd', $this->subfield_cd])
            ->andFilterWhere(['like', 'field_data', $this->field_data]);

        return $dataProvider;
    }
}
