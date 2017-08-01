<?php

use yii\db\Migration;

/**
 * Handles the creation of table `collection_dm`.
 */
class m170626_040304_create_collection_dm_table extends Migration
{
    /**
     * Idioma del contenido. Para AWS, se definirá en-US o en-GB
     * @var string 
     */
    private $language = "es-CO";
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
            'daily_late_fee' => $this->decimal(4,2)->notNull(),
        ]);
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/collection_dm.sql");
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
