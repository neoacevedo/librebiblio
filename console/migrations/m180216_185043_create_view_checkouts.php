<?php

use yii\db\Migration;

/**
 * Class m180216_185043_create_view_checkouts
 */
class m180216_185043_create_view_checkouts extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        if ($this->db->driverName === "mysql") {
            $sql = "CREATE OR REPLACE VIEW {{%checkouts}} AS "
                    . "SELECT c.bibid, c.id , m.id as mbr_id, c.barcode_nmbr, "
                    . "b.title, b.author, c.status_begin_dt, "
                    . "c.due_back_dt, m.pin, "
                    . "concat(m.last_name, ', ', m.first_name) member_name "
                    . "FROM {{%biblio}} b "
                    . "LEFT JOIN {{%biblio_copy}} c ON b.id = c.bibid "
                    . "LEFT JOIN {{%member}} m ON c.mbr_id = m.id "
                    . "WHERE c.status_cd = 'out';";
        } elseif ($this->db->driverName === "pgsql") {
            $sql = "CREATE OR REPLACE VIEW {{%checkouts}} AS "
                    . "SELECT c.bibid, c.id , m.id as mbr_id, c.barcode_nmbr, "
                    . "b.title, b.author, c.status_begin_dt, "
                    . "c.due_back_dt, m.pin, "
                    . "textcat(textcat(m.last_name,text ' '),m.first_name) AS member_name "
                    . "FROM {{%biblio}} b "
                    . "LEFT JOIN {{%biblio_copy}} c ON b.id = c.bibid "
                    . "LEFT JOIN {{%member}} m ON c.mbr_id = m.id "
                    . "WHERE c.status_cd = 'out';";
        }
        $this->db->createCommand($sql)->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->db->createCommand("drop view if exists {{%checkouts}}")->execute();
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180216_185043_create_view_checkouts cannot be reverted.\n";

      return false;
      }
     */
}
