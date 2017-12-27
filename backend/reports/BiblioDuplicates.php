<?php

namespace backend\reports;

use Yii;
use yii\base\Model;

/**
 * Description of Acquisitions
 *
 * @author nestor
 */
class BiblioDuplicates extends Model {

    public $title;
    public $category;
    public $materialType;
    public $collection;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->title = 'Duplicated Titles';
        $this->category = 'Cataloging';
    }

    public function attributeLabels() {
        return [
            'title' => Yii::t('app/report', 'Duplicated Titles'),
            'category' => Yii::t('app', 'Cataloging'),
        ];
    }

    public function run() {
        $sql = '';
    }

}
