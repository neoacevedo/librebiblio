<?php

use yii\db\Migration;

/**
 * Handles the creation of table `material_type_dm`.
 */
class m170627_010911_create_material_type_dm_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%material_type_dm}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'image_file' => $this->string(128),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%material_type_dm}}');
    }
}
