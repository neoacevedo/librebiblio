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
namespace backend\reports;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\reports\Checkouts;

/**
 * CheckoutsSearch represents the model behind the search form of `backend\reports\Checkouts`.
 */
class CheckoutsSearch extends Checkouts
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'id', 'mbr_id'], 'integer'],
            [['barcode_nmbr', 'title', 'author', 'status_begin_dt', 'due_back_dt', 'member_name'], 'safe'],
            [['pin'], 'number'],
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
            ->andFilterWhere(['like', 'member_name', $this->member_name]);

        return $dataProvider;
    }

}
