<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%theme}}`.
 */
class m220715_153528_add_settings_column_to_theme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%theme}}', 'settings', $this->text()->after('active')->comment("json settings"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%theme}}', 'settings');
    }
}
