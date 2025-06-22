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
use backend\reports\CheckoutStats;
use yii\db\Query;
use common\models\BiblioCopy;
use common\models\BiblioStatusHistory;

/**
 * CheckoutStatsSearch represents the model behind the search form of `backend\reports\CheckoutStats`.
 */
class CheckoutStatsSearch extends CheckoutStats
{
    /** @var string */
    public $cycle;

    /** @var integer */
    public $checkoutCount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['checkoutCount'], 'integer'],
            [['cycle'], 'string'],
            [['biblio_copy', 'biblio_status_hist'], 'safe']
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
        $query = new Query();
        if ($params['timespan'] == "w") {
            $query->select(["DATE_FORMAT((h.created_at),
			'%x %v') as cycle",
                "COUNT(*) as checkoutCount"
            ]);
        } elseif ($params['timespan'] == "m") {
            $query->select(["DATE_FORMAT((h.created_at),
			'%Y %m') as cycle",
                "COUNT(*) as checkoutCount"
            ]);
        } else {
            $query->select(["CONCAT(YEAR(h.created_at),
			' ', QUARTER(h.created_at)) as cycle",
                "COUNT(*) as checkoutCount"
            ]);
        }

        $query
            ->from('{{%biblio_copy}} c')
            ->leftJoin('{{%biblio_status_hist}} h', 'h.copyid = c.id');

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

        $dataProvider->sort->attributes['cycle'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['cycle' => SORT_ASC],
            'desc' => ['cycle' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['checkoutCount'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['checkoutCount' => SORT_ASC],
            'desc' => ['checkoutCount' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'cycle' => $this->cycle,
            'checkoutCount' => $this->checkoutCount,
            'h.status_cd' => 'out'
        ]);

        $query->groupBy("cycle");

        return $dataProvider;
    }
}
