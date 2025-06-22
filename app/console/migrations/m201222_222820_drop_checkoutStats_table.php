<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%checkoutStats}}`.
 */
class m201222_222820_drop_checkoutStats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("DROP VIEW {{%checkoutStats}}")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
