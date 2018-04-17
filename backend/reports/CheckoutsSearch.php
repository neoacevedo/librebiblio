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
use backend\reports\Checkouts;

/**
 * CheckoutsSearch represents the model behind the search form of `backend\reports\Checkouts`.
 */
class CheckoutsSearch extends Checkouts {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['bibid', 'id', 'mbr_id'], 'integer'],
            [['barcode_nmbr', 'title', 'author', 'status_begin_dt', 'due_back_dt', 'name'], 'safe'],
            [['pin'], 'number'],
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
        $query = Checkouts::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pagination']
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
            'bibid' => $this->bibid,
            'id' => $this->id,
            'mbr_id' => $this->mbr_id,
            'pin' => $this->pin,
        ]);

        $query->andFilterWhere(['<=', 'due_back_dt', $this->due_back_dt])
                ->andFilterWhere(['>=', 'status_begin_dt', $this->status_begin_dt])
                ->andFilterWhere(['like', 'barcode_nmbr', $this->barcode_nmbr])
                ->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'author', $this->author])
                ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
