<?php

use yii\db\Migration;

class m250627_162040_alter_nombre_column_from_theme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(table: '{{%theme}}', column: 'name', type: $this->string(length: 45)->notNull()->defaultValue(default: '')->comment(comment: 'Nombre del tema'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->string(length: 15)->notNull();
    }
}
