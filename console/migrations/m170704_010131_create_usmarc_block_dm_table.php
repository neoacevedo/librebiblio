<?php

use yii\db\Migration;

/**
 * Handles the creation of table `usmarc_block_dm`.
 */
class m170704_010131_create_usmarc_block_dm_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%usmarc_block_dm}}', [
            'block_mbr' => $this->smallInteger(1),
            'description' => $this->string(80)->notNull(),
            'PRIMARY KEY (block_mbr)'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%usmarc_block_dm}}');
    }
}
