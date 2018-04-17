<?php

use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 */
class m170822_211718_create_settings_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        // pendiente definir items_per_page, themeid        
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'library_name' => $this->string(128),
            'library_image_url' => $this->string(255),
            'use_image_flg' => $this->smallInteger(1)->unsigned(),
            'library_hours' => $this->string(128)->notNull(),
            'library_phone' => $this->string(49),
            'purge_history_after_months' => $this->smallInteger()->notNull(),
            'block_checkouts_when_fines_due' => $this->char(1)->notNull(),
            'hold_max_days' => $this->smallInteger()->notNull(),
            'offline' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'items_per_page' => $this->integer()->defaultValue(20),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('{{%settings}}');
    }

}
