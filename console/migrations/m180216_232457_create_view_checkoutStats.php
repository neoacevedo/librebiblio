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
        if ($this->db->driverName === 'mysql') {
            $sql = "CREATE OR REPLACE VIEW {{%checkoutStats}} AS "
                    . "SELECT c.id, h.created_at, "
                    . "COUNT(*) checkoutCount "
                    . "FROM {{%biblio_copy}} c, {{%biblio_status_hist}} h "
                    . "WHERE c.bibid = h.bibid "
                    . "AND c.id = h.copyid "
                    . "AND h.status_cd = 'out';";
        } else if ($this->db->driverName === 'pgsql') {
            $sql = "CREATE OR REPLACE VIEW {{%checkoutStats}} AS "
                    . "SELECT c.id, h.created_at, "
                    . "(SELECT COUNT(h.created_at) FROM {{%biblio_status_hist}} h WHERE h.copyid = c.id) checkoutCount "
                    . "FROM {{%biblio_copy}} c "
                    . "LEFT JOIN {{%biblio_status_hist}} h ON c.id = h.copyid "
                    . "AND c.bibid = h.bibid "
                    . "AND h.status_cd = 'out';";
        }
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
