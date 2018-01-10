<?php

use yii\db\Migration;

/**
 * Handles the creation of table `collection_dm`.
 */
class m170626_040304_create_collection_dm_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $language = str_replace("_", "-", locale_get_default());
        $this->createTable('{{%collection_dm}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'days_due_back' => $this->smallInteger()->unsigned()->notNull(),
            'daily_late_fee' => $this->decimal(4,2)->notNull(),
        ]);
        
        $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/collection_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%collection_dm}}');
    }
}
