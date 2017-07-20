<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mbr_classify`.
 */
class m170627_013949_create_mbr_classify_dm_table extends Migration
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
        $this->createTable('{{%mbr_classify_dm}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'max_fines' => $this->decimal(4,2)->notNull(),
        ]);
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/mbr_classify_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%mbr_classify_dm}}');
    }
}
