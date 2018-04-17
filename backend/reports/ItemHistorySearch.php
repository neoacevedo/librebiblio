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
use backend\reports\ItemHistory;

/**
 * ItemHistorySearch represents the model behind the search form of `backend\reports\ItemHistory`.
 */
class ItemHistorySearch extends ItemHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mbr_id'], 'integer'],
            [['call_num', 'title', 'author', 'member', 'checkout', 'due'], 'safe'],
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
        $query = ItemHistory::find();

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
            'id' => $this->id,
            'mbr_id' => $this->mbr_id,
            'checkout' => $this->checkout,
            'due' => $this->due,
        ]);

        $query->andFilterWhere(['like', 'call_num', $this->call_num])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'member', $this->member]);

        return $dataProvider;
    }
}
