<?php

use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 */
class m170822_211718_create_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // pendiente definir items_per_page, themeid
        $this->createTable('{{%settings}}', [
            'library_name' => $this->string(128),
            'library_image_url' => $this->string(255),
            'use_image_flg' => $this->char(1),
            'library_hours' => $this->string(128)->notNull(),
            'library_phone' => $this->string(49),
            'purge_history_after_months' => $this->smallInteger()->notNull(),
            'block_checkouts_when_fines_due' => $this->char(1)->notNull(),
            'hold_max_days' => $this->smallInteger()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%settings}}');
    }
}
