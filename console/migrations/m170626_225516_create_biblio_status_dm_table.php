<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio_status_dm`.
 */
class m170626_225516_create_biblio_status_dm_table extends Migration
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
        $this->createTable('{{%biblio_status_dm}}', [
            'code' => $this->char(3)->notNull(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
        ]);
        
        // add primary keys
        $this->addPrimaryKey('bibliostatusdm_pk', '{{%biblio_status_dm}}', 'code');
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/biblio_status_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%biblio_status_dm}}');
    }
}
