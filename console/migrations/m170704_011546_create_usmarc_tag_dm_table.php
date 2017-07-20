<?php

use yii\db\Migration;

/**
 * Handles the creation of table `usmarc_tag_dm`.
 */
class m170704_011546_create_usmarc_tag_dm_table extends Migration
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
        $this->createTable('{{%usmarc_tag_dm}}', [
            'block_nmbr' => $this->smallInteger()->notNull(),
            'tag' => $this->smallInteger()->notNull(),
            'description' => $this->string(80)->notNull(),
            'ind1_description' => $this->string(80)->notNull(),
            'ind2_description' => $this->string(80)->notNull(),
            'repeatable_flg' => $this->char(1)->notNull(),
            'PRIMARY KEY(block_nmbr,tag)'
        ]);
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/usmarc_tag_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%usmarc_tag_dm}}');
    }
}
