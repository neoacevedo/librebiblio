<?php

/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Cart;

/**
 * CartSearch represents the model behind the search form about `frontend\models\Cart`.
 */
class CartSearch extends Cart
{
    public $biblio;
    public $biblioCopy;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'copyid', 'mbr_id'], 'integer'],
            [['status'], 'string', 'max' => 3],
            [['biblio', 'biblioCopy'], 'safe'],
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
        $query = Cart::find();

        // add conditions that should always apply here
        $query->joinWith(['biblio', 'biblioCopy'], true, 'LEFT JOIN');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'biblio' => [
                        // The tables are the ones our relation are configured to
                        // in my case they are prefixed with "tbl_"
                        'asc' => ['{{%biblio}}.title' => SORT_ASC],
                        'desc' => ['{{%biblio}}.title' => SORT_DESC],
                    ],
                    'biblioCopy' => [
                        'asc' => ['{{%biblio_copy}}.barcode_nmbr' => SORT_ASC],
                        'desc' => ['{{%biblio_copy}}.barcode_nmbr' => SORT_DESC],
                    ]
                ]
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
            'status' => $this->status,
            '{{%cart}}.mbr_id' => \Yii::$app->user->id,
            '{{%biblio_copy}}.barcode_nmbr' => $this->biblioCopy
        ]);

        $query->andFilterWhere(['like', '{{%biblio}}.title', $this->biblio]);
        return $dataProvider;
    }
}
