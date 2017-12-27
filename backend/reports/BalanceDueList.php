<?php

namespace backend\reports;

use Yii;
use yii\base\Model;

/**
 * Description of Acquisitions
 *
 * @author nestor
 */
class BalanceDueList extends Model {

    public $title;
    public $category;
    public $materialType;
    public $collection;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->title = 'Balance Due Member List';
        $this->category = 'Circulation';
    }

    public function attributeLabels() {
        return [
            'title' => Yii::t('app/report', 'Balance Due Member List'),
            'category' => Yii::t('app', 'Circulation'),
        ];
    }

    public function run() {
        $sql = 'select m.mbrid, m.barcode_nmbr,
		concat(m.last_name, \', \', m.first_name) name,
		sum(acct.amount) balance
	from member m, member_account acct
	where m.mbrid=acct.mbrid
	group by m.mbrid, m.barcode_nmbr, m.last_name, m.first_name
.	if_set minimum
		having balance >= %#minimum%
.	end if_set
.	order_by_expr';
    }

}
