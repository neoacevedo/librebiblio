<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BiblioCopy;

/**
 * BiblioCopySearch represents the model behind the search form about `common\models\BiblioCopy`.
 */
class BiblioHoldSearch extends BiblioHold {

    public $biblio;
    public $biblioCopy;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'bibid', 'copyid', 'mbr_id'], 'integer'],
            [['mbr_id', 'biblio', 'biblioCopy', 'hold_begin_dt'], 'safe'],
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
        $query = BiblioHold::find();

        // add conditions that should always apply here
        $query->joinWith(['biblio', 'biblioCopy'], true, 'LEFT JOIN');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        // The key is the attribute name on our "TourSearch" instance
        $dataProvider->sort->attributes['biblioTitle'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%biblio}}.title' => SORT_ASC],
            'desc' => ['{{%biblio}}.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{%biblio_copy}}.id' => $this->id,
            '{{%biblio_copy}}.bibid' => $this->bibid]);
        if (null !== $this->biblioCopy && null !== $this->biblio) {
            $query->andFilterWhere(['<=', 'date({{%biblio_copy}}.status_begin_dt)', $this->biblioCopy->status_begin_dt])
                    ->andFilterWhere(['<=', 'date({{%biblio_copy}}.due_back_dt)', $this->biblioCopy->due_back_dt])
                    ->andFilterWhere(['like', '{{%biblio_copy}}.copy_desc', $this->biblioCopy->copy_desc])
                    ->andFilterWhere(['like', '{{%biblio_copy}}.barcode_nmbr', $this->biblioCopy->barcode_nmbr])
                    ->andFilterWhere(['like', '{{%biblio}}.title', $this->biblio->title]);
        }

        $query->andFilterWhere(['{{%biblio_hold}}.mbr_id' => $this->mbr_id]);

        return $dataProvider;
    }

}
