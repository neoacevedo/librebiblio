<?php

use yii\db\Migration;

/**
 * Class m180216_232457_create_view_checkoutStats
 */
class m180216_232457_create_view_checkoutStats extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $sql = "CREATE OR REPLACE VIEW {{%checkoutStats}} AS "
                . "SELECT c.id, h.created_at, "
                . "COUNT(*) checkoutCount "
                . "FROM {{%biblio_copy}} c, {{%biblio_status_hist}} h "
                . "WHERE c.bibid = h.bibid "
                . "AND c.id = h.copyid "
                . "AND h.status_cd = 'out' "
                . "GROUP BY h.created_at;";
        $this->db->createCommand($sql)->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->db->createCommand("drop view if exists {{%checkoutStats}}")->execute();
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180216_232457_create_view_checkoutStats cannot be reverted.\n";

      return false;
      }
     */
}
