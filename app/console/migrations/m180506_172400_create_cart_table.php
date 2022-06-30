<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m180506_172400_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'bibid' => $this->integer()->notNull(),
            'copyid' => $this->integer()->notNull(),
            'status' => $this->string(3)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cart');
    }
}
