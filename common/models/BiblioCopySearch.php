<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BiblioCopy;

/**
 * BiblioCopySearch represents the model behind the search form about `common\models\BiblioCopy`.
 */
class BiblioCopySearch extends BiblioCopy {

    public $biblio;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'bibid', 'mbr_id', 'renewal_count'], 'integer'],
            [['created_at', 'mbr_id', 'biblio', 'updated_at', 'copy_desc', 'barcode_nmbr', 'status_cd', 'status_begin_dt', 'due_back_dt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = BiblioCopy::find();

        // add conditions that should always apply here
        $query->joinWith(['biblio']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // The key is the attribute name on our "TourSearch" instance
        $dataProvider->sort->attributes['biblioTitle'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%biblio}}.title' => SORT_ASC],
            'desc' => ['{{%biblio}}.title' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
                    '{{%biblio_copy}}.id' => $this->id,
                    '{{%biblio_copy}}.bibid' => $this->bibid])
                ->andFilterWhere(
                        ['<=', 'date({{%biblio_copy}}.created_at)', $this->created_at])
                ->andFilterWhere(
                        ['<=', 'date({{%biblio_copy}}.updated_at)', $this->updated_at])
                ->andFilterWhere(['<=', 'date(status_begin_dt)', $this->status_begin_dt])
                ->andFilterWhere(['<=', 'date(due_back_dt)', $this->due_back_dt])
                ->andFilterWhere(['mbr_id' => $this->mbr_id,
                    'renewal_count' => $this->renewal_count,
        ]);

        $query->andFilterWhere(['like', 'copy_desc', $this->copy_desc])
                ->andFilterWhere(['like', 'barcode_nmbr', $this->barcode_nmbr])
                ->andFilterWhere(['like', 'status_cd', $this->status_cd])
                ->andFilterWhere(['like', '{{%biblio}}.title', $this->biblio]);

        return $dataProvider;
    }

}
