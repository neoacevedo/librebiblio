<?php

use yii\db\Migration;

/**
 * Handles the creation of table `usmarc_indicator_dm`.
 */
class m170704_010737_create_usmarc_indicator_dm_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('{{%usmarc_indicator_dm}}', [
            'tag' => $this->smallInteger()->notNull(),
            'indicator_nmbr' => $this->smallInteger()->notNull(),
            'indicator_cd' => $this->char(1)->notNull(),
            'description' => $this->string(255)->notNull(),
            'PRIMARY KEY (tag, indicator_nmbr, indicator_cd)'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('{{%usmarc_indicator_dm}}');
    }

}
