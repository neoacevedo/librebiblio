<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%theme}}`.
 */
class m220803_213601_add_sourcePath_column_to_theme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%theme}}', 'sourcePath', $this->string()->notNull()->after('frontend'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%theme}}', 'sourcePath');
    }
}
