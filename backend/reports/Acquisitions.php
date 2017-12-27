<?php

namespace backend\reports;

use Yii;
use yii\base\Model;

/**
 * Description of Acquisitions
 *
 * @author nestor
 */
class Acquisitions extends Model {

    public $title;
    public $category;
    public $materialType;
    public $collection;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->title = 'Acquisition';
        $this->category = 'Cataloging';
    }

    public function attributeLabels() {
        return [
            'title' => Yii::t('app/report', 'Acquisition'),
            'category' => Yii::t('app', 'Cataloging'),
        ];
    }

    public function run() {
        $sql = 'select b.bibid, concat_ws(\' \', b.call_nmbr1, b.call_nmbr2, b.call_nmbr3) callno,
		c.barcode_nmbr, c.create_dt, b.title, b.author,
		coll.description as collection, mat.description as material
	from biblio_copy c, biblio b,
		collection_dm as coll, material_type_dm as mat
	where b.bibid=c.bibid
		and mat.code=b.material_cd
		and coll.code=b.collection_cd
.	if_set newer
		and c.create_dt >= %newer%
.	end if_set
.	if_set older
		and c.create_dt < %older%
.	end if_set
.	if_not_equal collection ""
		and b.collection_cd = %collection%
.	end if_not_equal
.	if_not_equal material ""
		and b.material_cd = %material%
.	end if_not_equal
	group by c.barcode_nmbr, b.title, b.author
.	order_by_expr';
    }

}
