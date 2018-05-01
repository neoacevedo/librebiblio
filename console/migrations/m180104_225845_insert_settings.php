<?php

use yii\db\Migration;

/**
 * Class m180104_225845_insert_settings
 */
class m180104_225845_insert_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert("{{%settings}}", [
            'library_name' => 'OpenBiblio2', 
            'library_image_url' => 'openbiblio2.png',
            'use_image_flg' => 1,
            'library_hours' => 'L-V 08:00 - 16:30',
            'library_phone' => '+571 1234567',
            'purge_history_after_months' => 6,
            'block_checkouts_when_fines_due' => 1,
            'hold_max_days' => 14,
            'offline' => 0,
            'items_per_page' => 20,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180104_225845_insert_settings cannot be reverted.\n";

        return false;
    }
    */
}
