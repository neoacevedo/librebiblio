<?php

use yii\db\Migration;

/**
 * Handles the creation of table `session`.
 */
class m171220_223908_create_session_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->char(40)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
        ]);
        
        $this->addPrimaryKey('pk-id', '{{%session}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}
