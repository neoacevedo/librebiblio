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
namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CheckoutPrivs;

/**
 * CheckoutPrivsSearch represents the model behind the search form about `common\models\CheckoutPrivs`.
 */
class CheckoutPrivsSearch extends CheckoutPrivs
{

    public $materialType;
    public $memberClassify;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'checkout_limit', 'renewal_limit'], 'integer'],
            [['materialType', 'memberClassify'], 'safe']
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
        $query = CheckoutPrivs::find();

        // join a la tabla user
        $query->joinWith(['materialType', 'memberClassify']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['materialType'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%materialtype_dm}}.description' => SORT_ASC],
            'desc' => ['{{%material_type_dm}}.description' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['memberClassify'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%mbr_classify_dm}}.description' => SORT_ASC],
            'desc' => ['{{%mbr_classify_dm}}.description' => SORT_DESC],
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
            'checkout_limit' => $this->checkout_limit,
            'renewal_limit' => $this->renewal_limit,
        ])->andFilterWhere(['like', '{{%material_type_dm}}.description', $this->materialType]);

        if (null !== $this->memberClassify) {
            $query->andFilterWhere(['like', '{{%mbr_classify_dm}}.description', $this->memberClassify->description]);
        }

        return $dataProvider;
    }

}
