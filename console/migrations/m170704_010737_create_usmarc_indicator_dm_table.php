<?php

use yii\db\Migration;

/**
 * Handles the creation of table `usmarc_indicator_dm`.
 */
class m170704_010737_create_usmarc_indicator_dm_table extends Migration
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
        $this->createTable('{{%usmarc_indicator_dm}}', [
            'tag' => $this->smallInteger()->notNull(),
            'indicator_nmbr' => $this->smallInteger()->notNull(),
            'indicator_cd' => $this->char(1)->notNull(),
            'description' => $this->string(80)->notNull(),
            'PRIMARY KEY (tag, indicator_nmbr, indicator_cd)'
        ]);
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/usmarc_indicator_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%usmarc_indicator_dm}}');
    }
}
