<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction_type`.
 */
class m170704_002732_create_transaction_type_dm_table extends Migration
{
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
    }
    
    public function safeUp() {
        $language = str_replace("_", "-", locale_get_default());
        $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/transaction_type_dm.sql");
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
