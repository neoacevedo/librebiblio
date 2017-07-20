<?php

use yii\db\Migration;

/**
 * Handles the creation of table `material_type_dm`.
 */
class m170626_174341_create_material_type_dm_table extends Migration
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
        $this->createTable('{{%material_type_dm}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'image_file' => $this->string(128),
        ]);
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/material_type_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%material_type_dm}}');
    }
}
