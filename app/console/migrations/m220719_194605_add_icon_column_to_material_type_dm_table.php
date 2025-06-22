<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%material_type_dm}}`.
 */
class m220719_194605_add_icon_column_to_material_type_dm_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%material_type_dm}}', 'icon', $this->string(45)->notNull()->after('default_flg'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%material_type_dm}}', 'icon');
    }
}
