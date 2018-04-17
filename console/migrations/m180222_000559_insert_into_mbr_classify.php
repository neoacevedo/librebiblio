<?php

use yii\db\Migration;

/**
 * Class m180222_000559_insert_into_mbr_classify
 */
class m180222_000559_insert_into_mbr_classify extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/mbr_classify_dm.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es-CO/mbr_classify_dm.sql");
        }
        if ($this->db->driverName === "mysql") {
            $this->db->createCommand($sql)->execute();
        } else if ($this->db->driverName === "pgsql") {
            $sql_array = explode(";", $sql);
            foreach ($sql_array as $sql) {
                $this->db->createCommand($sql)->execute();
                // incrementar la secuencia MANUALMENTE
                $this->db->createCommand("SELECT setval('mbr_classify_dm_id_seq', (SELECT MAX(id) from {{%mbr_classify_dm}}));")->execute();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return true;
    }
}
