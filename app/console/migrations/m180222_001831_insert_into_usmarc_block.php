<?php

use yii\db\Migration;

/**
 * Class m180222_001831_insert_into_usmarc_block
 */
class m180222_001831_insert_into_usmarc_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/usmarc_block_dm.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es/usmarc_block_dm.sql");
        }
        if ($this->db->driverName === "mysql") {
            $this->db->createCommand($sql)->execute();
        } elseif ($this->db->driverName === "pgsql") {
            $sql_array = explode(";", $sql);
            foreach ($sql_array as $sql) {
                $this->db->createCommand($sql)->execute();
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
      echo "m180222_002155_insert_into_usmarc_block cannot be reverted.\n";

      return false;
      }
     */
}
