<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%checkoutStats}}`.
 */
class m201222_201530_add_cycle_column_to_checkoutStats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%checkoutStats}}', 'cycle', $this->string(1)->defaultValue('w'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%checkoutStats}}', 'cycle');
    }
}
