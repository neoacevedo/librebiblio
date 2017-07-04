<?php

use yii\db\Migration;

/**
 * Handles the creation of table `usmarc_tag_dm`.
 */
class m170704_011546_create_usmarc_tag_dm_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%usmarc_tag_dm}}', [
            'block_nmbr' => $this->smallInteger()->notNull(),
            'tag' => $this->smallInteger()->notNull(),
            'description' => $this->string(80)->notNull(),
            'ind1_description' => $this->string(80)->notNull(),
            'ind2_description' => $this->string(80)->notNull(),
            'repeatable_flg' => $this->char(1)->notNull(),
            'PRIMARY KEY(block_nmbr,tag)'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%usmarc_tag_dm}}');
    }
}
