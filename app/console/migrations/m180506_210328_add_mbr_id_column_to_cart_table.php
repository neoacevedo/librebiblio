<?php

use yii\db\Migration;

/**
 * Handles adding mbr_id to table `cart`.
 */
class m180506_210328_add_mbr_id_column_to_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cart', 'mbr_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cart', 'mbr_id');
    }
}
