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
class BiblioHoldSearch extends BiblioHold
{
    public $status_begin_dt;
    public $due_back_dt;
    public $copy_desc;
    public $barcode_nmbr;
    public $title;
    public $author;
    public $material;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bibid', 'copyid', 'mbr_id'], 'integer'],
            [['mbr_id', 'status_begin_dt', 'due_back_dt', "copy_desck", 'barcode_nmbr', 'title', 'author', 'material', 'hold_begin_dt'], 'safe'],
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
        $query = BiblioHold::find()
            ->joinWith(['biblio', 'biblioCopy']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // The key is the attribute name on our "TourSearch" instance
        $dataProvider->sort->attributes['title'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%biblio}}.title' => SORT_ASC],
            'desc' => ['{{%biblio}}.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['author'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%biblio}}.author' => SORT_ASC],
            'desc' => ['{{%biblio}}.author' => SORT_DESC],
        ];

        $dataProvider->sort->attributes["material"] = [
            'asc' => ["{{%biblio}}.material_cd" => SORT_ASC],
            'desc' => ["{{%biblio}}.material_cd" => SORT_DESC],
        ];

        $dataProvider->sort->attributes["barcode_nmbr"] = [
            'asc' => ["{{%biblio_copy}}.barcode_nmbr" => SORT_ASC],
            'desc' => ["{{%biblio_copy}}.barcode_nmbr" => SORT_DESC],
        ];

        $dataProvider->sort->attributes["due_back_dt"] = [
            'asc' => ["{{%biblio_copy}}.due_back_dt" => SORT_ASC],
            'desc' => ["{{%biblio_copy}}.due_back_dt" => SORT_DESC],
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
            '{{%biblio_copy}}.bibid' => $this->bibid])
            ->andFilterWhere(['<=', 'date({{%biblio_copy}}.status_begin_dt)', $this->status_begin_dt])
            ->andFilterWhere(['<=', 'date({{%biblio_copy}}.due_back_dt)', $this->due_back_dt])
            ->andFilterWhere(['like', '{{%biblio_copy}}.copy_desc', $this->copy_desc])
            ->andFilterWhere(['like', '{{%biblio_copy}}.barcode_nmbr', $this->barcode_nmbr])
            ->andFilterWhere(['like', '{{%biblio}}.title', $this->title])
            ->andFilterWhere(["{{%biblio}}.material_cd" => $this->material])
            ->andFilterWhere(['{{%biblio_hold}}.mbr_id' => $this->mbr_id]);

        return $dataProvider;
    }
}
