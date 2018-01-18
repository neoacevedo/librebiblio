<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MemberAccount;

/**
 * MemberAccountSearch represents the model behind the search form of `common\models\MemberAccount`.
 */
class MemberAccountSearch extends MemberAccount {

    public $user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'mbr_id'], 'integer'],
            [['user', 'created_at', 'transaction_type_cd', 'description'], 'safe'],
            [['amount'], 'number'],
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
        $query = MemberAccount::find();

        $query->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['user'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%user}}.username' => SORT_ASC],
            'desc' => ['{{%user}}.username' => SORT_DESC],
        ];

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
            'created_at' => $this->created_at,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'transaction_type_cd', $this->transaction_type_cd])
                ->andFilterWhere(['like', '{{%user}}.username', $this->user])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
