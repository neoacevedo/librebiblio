<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mbr_classify`.
 */
class m170626_040242_create_mbr_classify_dm_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('{{%mbr_classify_dm}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull()->defaultValue('N'),
            'max_fines' => $this->decimal(4, 2)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('{{%mbr_classify_dm}}');
    }

}
