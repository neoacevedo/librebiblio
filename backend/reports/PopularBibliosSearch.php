<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace backend\reports;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\reports\PopularBiblios;

/**
 * PopularBibliosSearch represents the model behind the search form about `backend\reports\PopularBiblios`.
 */
class PopularBibliosSearch extends PopularBiblios
{
    public $groupBy;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'checkoutCount'], 'integer'],
            [['barcode_nmbr', 'title', 'author'], 'safe'],
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
        $query = PopularBiblios::find();

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
            'checkoutCount' => $this->checkoutCount,
        ]);
        
        if($this->groupBy === "copy") {
            $query->andFilterWhere(['like', 'barcode_nmbr', $this->barcode_nmbr]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author', $this->author]);
        
        if($this->groupBy === "biblio") {
            $query->groupBy(["id", "title", "author"]);
        } else {
            $query->groupBy(["id", "barcode_nmbr", "title", "author"]);
        }

        return $dataProvider;
    }
}
