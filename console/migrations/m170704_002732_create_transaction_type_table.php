<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction_type`.
 */
class m170704_002732_create_transaction_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%transaction_type}}', [
            'code' => $this->char(2)->notNull(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'PRIMARY KEY (code)'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%transaction_type}}');
    }
}
