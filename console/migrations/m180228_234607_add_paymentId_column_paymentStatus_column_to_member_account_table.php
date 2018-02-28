<?php

use yii\db\Migration;

/**
 * Handles adding paymentId_column_paymentStatus to table `member_account`.
 */
class m180228_234607_add_paymentId_column_paymentStatus_column_to_member_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%member_account}}', 'paymentId', $this->string(50)->after('transaction_type_cd'));
        $this->addColumn('{{%member_account}}', 'paymentStatus', $this->string(20)->after('paymentId'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%member_account}}', 'paymentId');
        $this->dropColumn('{{%member_account}}', 'paymentStatus');
    }
}
