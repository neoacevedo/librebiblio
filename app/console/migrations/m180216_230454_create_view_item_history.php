<?php

use yii\db\Migration;

/**
 * Class m180216_230454_create_view_item_history
 */
class m180216_230454_create_view_item_history extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            $sql = "CREATE OR REPLACE VIEW {{%item_history}} AS "
                    . "SELECT b.id, "
                    . "CONCAT_WS(' ', b.call_nmbr1, b.call_nmbr2, b.call_nmbr3) AS call_num, "
                    . "CONCAT(b.title, ' ', IFNULL(b.title_remainder, '')) AS title, "
                    . "b.author, m.id as mbr_id, "
                    . "CONCAT(m.last_name,', ',  m.first_name) AS member, "
                    . "s.created_at AS checkout, "
                    . "s.due_back_dt AS due "
                    . "FROM {{%biblio}} b "
                    . "LEFT JOIN {{%biblio_status_hist}} s ON s.bibid = b.id "
                    . "LEFT JOIN {{%member}} m ON s.mbr_id = m.id "
                    . "WHERE s.status_cd='out'";
        } elseif ($this->db->driverName === 'pgsql') {
            $sql = "CREATE OR REPLACE VIEW {{%item_history}} AS "
                    . "SELECT b.id, "
                    . "CONCAT_WS(' ', b.call_nmbr1, b.call_nmbr2, b.call_nmbr3) AS call_num, "
                    . "textcat(textcat(b.title, text ' '), COALESCE(b.title_remainder, '')) AS title, "
                    . "b.author, m.id as mbr_id, "
                    . "textcat(textcat(m.last_name,text ' '),m.first_name) AS member, "
                    . "s.created_at AS checkout, "
                    . "s.due_back_dt AS due "
                    . "FROM {{%biblio}} b "
                    . "LEFT JOIN {{%biblio_status_hist}} s ON s.bibid = b.id "
                    . "LEFT JOIN {{%member}} m ON s.mbr_id = m.id "
                    . "WHERE s.status_cd='out'";
        }
        $this->db->createCommand($sql)->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->db->createCommand("drop view if exists {{%item_history}}")->execute();
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180216_230454_create_view_item_history cannot be reverted.\n";

      return false;
      }
     */
}
