<?php

use yii\db\Migration;

/**
 * Handles the creation of table `collection_dm`.
 */
class m170627_011354_create_collection_dm_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%collection_dm}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'days_due_back' => $this->smallInteger()->unsigned()->notNull(),
            'dayli_late_fee' => $this->decimal(4,2)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%collection_dm}}');
    }
}
