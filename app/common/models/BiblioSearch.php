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
use common\models\Biblio;

/**
 * BiblioSearch represents the model behind the search form about `common\models\Biblio`.
 */
class BiblioSearch extends Biblio
{
    public $user;
    public $materialType;
    public $collection;
    public $biblioFields;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'title_remainder', 'responsibility_stmt', 'author', 'topic1', 'topic2', 'topic3', 'topic4', 'topic5', 'call_nmbr1', 'call_nmbr2', 'call_nmbr3'], 'string'],
            [[
                'user', 'image_file', 'materialType', 'collection', 'created_at', 'updated_at',
                'opac_flg', 'biblioFields'
            ], 'safe'],
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
        $query = Biblio::find()
            ->joinWith(['user', 'materialType', 'collection']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user'] = [
                    'asc' => ["{{%user}}.firstName" => SORT_ASC, "{{%user}}.lastName" => SORT_ASC],
                    'desc' => ["{{%user}}.firstName" => SORT_DESC, "{{%user}}.lastName" => SORT_DESC],
        ];

        $dataProvider->sort->attributes['materialType'] = [
                    'asc' => ["{{%material_type_dm}}.description" => SORT_ASC],
                    'desc' => ["{{%material_type_dm}}.description" => SORT_DESC],
        ];

        $dataProvider->sort->attributes['collection'] = [
                    'asc' => ["{{%collection_dm}}.firstName" => SORT_ASC],
                    'desc' => ["{{%collection_dm}}.firstName" => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{%biblio}}.id' => $this->id
        ])
            ->andFilterWhere(
                ['<=', 'date({{%biblio}}.created_at)', $this->created_at]
            )
            ->andFilterWhere(
                ['<=', 'date({{%biblio}}.updated_at)', $this->updated_at]
            )->andFilterWhere(['like', 'call_nmbr1', $this->call_nmbr1])
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
            ->andFilterWhere(['{{%biblio}}.opac_flg' => $this->opac_flg])
            ->andFilterWhere(['like', '{{%user}}.username', $this->user])
            ->andFilterWhere(['{{%material_type_dm}}.description' => $this->materialType])
            ->andFilterWhere(['{{%collection_dm}}.description' => $this->collection]);
        return $dataProvider;
    }
}
