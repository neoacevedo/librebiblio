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
use DateTime;

/**
 * BiblioCopySearch represents the model behind the search form about `common\models\BiblioCopy`.
 */
class BiblioCopySearch extends BiblioCopy
{
    public $title;
    public $author;
    public $material;
    public $days_late;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'barcode_nmbr', 'bibid', 'mbr_id', 'renewal_count', 'days_late'], 'integer'],
            [['created_at', 'mbr_id', "title", "author", "material", 'updated_at', 'copy_desc', 'barcode_nmbr', 'status_cd', 'status_begin_dt', 'due_back_dt'], 'safe'],
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
        $query = BiblioCopy::find()
            ->joinWith(['biblio']);

        $datetime1 = new DateTime($this->due_back_dt);
        $datetime2 = new DateTime('now');
        $interval = $datetime1->diff($datetime2);
        $cero = 0;
        $diff = (int)$interval->format('%r%a');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes["title"] = [
            'asc' => ["{{%biblio}}.title" => SORT_ASC],
            'desc' => ["{{%biblio}}.title" => SORT_DESC],
            'label' => Yii::t('app', 'Title')
        ];

        $dataProvider->sort->attributes["author"] = [
            'asc' => ["{{%biblio}}.author" => SORT_ASC],
            'desc' => ["{{%biblio}}.author" => SORT_DESC],
            'label' => Yii::t('app', 'Author')
        ];

        $dataProvider->sort->attributes["material"] = [
            'asc' => ["{{%biblio}}.material_cd" => SORT_ASC],
            'desc' => ["{{%biblio}}.material_cd" => SORT_DESC],
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
                ->andFilterWhere(
                    ['<=', 'date({{%biblio_copy}}.created_at)', $this->created_at]
                )
                ->andFilterWhere(
                    ['<=', 'date({{%biblio_copy}}.updated_at)', $this->updated_at]
                )
                ->andFilterWhere(["{{%biblio}}.material_cd" => $this->material])
                ->andFilterWhere(['<=', 'date(status_begin_dt)', $this->status_begin_dt])
                ->andFilterWhere(['<=', 'date(due_back_dt)', $this->due_back_dt])
                ->andFilterWhere(['mbr_id' => $this->mbr_id,
                    'renewal_count' => $this->renewal_count,
        ]);

        $query->andFilterWhere(['like', 'copy_desc', $this->copy_desc])
                ->andFilterWhere(['like', 'barcode_nmbr', $this->barcode_nmbr])
                ->andFilterWhere(['like', 'status_cd', $this->status_cd])
                ->andFilterWhere(['like', '{{%biblio}}.title', $this->title])
                ->andFilterWhere(['like', '{{%biblio}}.author', $this->author])
        ;

        return $dataProvider;
    }
}
