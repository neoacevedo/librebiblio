<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction_type`.
 */
class m170704_002732_create_transaction_type_dm_table extends Migration
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
        $this->createTable('{{%transaction_type_dm}}', [
            'code' => $this->char(2)->notNull(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'PRIMARY KEY (code)'
        ]);
        
        $sql = file_get_contents(__DIR__."/sql/$this->language/transaction_type_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%transaction_type_dm}}');
    }
}
