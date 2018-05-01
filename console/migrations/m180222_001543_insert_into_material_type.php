<?php

use yii\db\Migration;

/**
 * Class m180222_001543_insert_into_material_type
 */
class m180222_001543_insert_into_material_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/material_type_dm.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es-CO/material_type_dm.sql");
        }
        if ($this->db->driverName === "mysql") {
            $this->db->createCommand($sql)->execute();
        } elseif ($this->db->driverName === "pgsql") {
            $sql_array = explode(";", $sql);
            foreach ($sql_array as $sql) {
                $this->db->createCommand($sql)->execute();
                // incrementar la secuencia MANUALMENTE
                $this->db->createCommand("SELECT setval('material_type_dm_id_seq', (SELECT MAX(id) from {{%material_type_dm}}));")->execute();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180222_001543_insert_into_material_type cannot be reverted.\n";

        return false;
    }
    */
}
