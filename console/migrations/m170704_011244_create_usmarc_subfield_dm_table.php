<?php

use yii\db\Migration;

/**
 * Handles the creation of table `usmarc_subfield_dm`.
 */
class m170704_011244_create_usmarc_subfield_dm_table extends Migration
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
        $this->createTable('{{%usmarc_subfield_dm}}', [
            'tag' => $this->smallInteger()->notNull(),
            'subfield_cd' => $this->char(1)->notNull(),
            'description' => $this->string(80)->notNull(),
            'repeatable_flg' => $this->char(1)->notNull(),
            'PRIMARY KEY (tag, subfield_cd)'
        ]);
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/usmarc_subfield_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%usmarc_subfield_dm}}');
    }
}
