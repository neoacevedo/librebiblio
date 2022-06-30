<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%settings}}`.
 */
class m210113_230628_add_cache_handler_column_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%settings}}', 'cache_handler', $this->string(32)->notNull()->defaultValue('file'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%settings}}', 'cache_handler');
    }
}
