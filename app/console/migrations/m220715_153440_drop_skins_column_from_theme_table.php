<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%theme}}`.
 */
class m220715_153440_drop_skins_column_from_theme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%theme}}', 'skin');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%theme}}', 'skin', $this->string(15)->after('active'));
    }
}
