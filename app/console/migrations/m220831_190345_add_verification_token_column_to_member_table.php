<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%member}}`.
 */
class m220831_190345_add_verification_token_column_to_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%member}}', 'verification_token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%member}}', 'verification_token');
    }
}
