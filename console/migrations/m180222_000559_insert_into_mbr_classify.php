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
        echo "Mbr Classify\n";
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
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180222_000559_insert_into_mbr_classify cannot be reverted.\n";

      return false;
      }
     */
}
