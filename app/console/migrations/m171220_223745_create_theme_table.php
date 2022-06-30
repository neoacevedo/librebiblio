<?php

use yii\db\Migration;

/**
 * Handles the creation of table `theme`.
 */
class m171220_223745_create_theme_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            $this->createTable('{{%theme}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string(15)->notNull(),
                'frontend' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
                'active' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
                'skin' => $this->string(15),
                'created_at' => $this->dateTime()
            ]);
        } elseif ($this->db->driverName === 'pgsql') {
            $this->createTable('{{%theme}}', [
                'id' => "SERIAL",
                'name' => $this->string(15)->notNull(),
                'frontend' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
                'active' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
                'skin' => $this->string(15),
                'created_at' => $this->dateTime()
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('{{%theme}}');
    }

}
