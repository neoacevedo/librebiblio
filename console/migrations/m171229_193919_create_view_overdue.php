<?php

use yii\db\Migration;

/**
 * Class m171229_193919_create_view_overdue
 */
class m171229_193919_create_view_overdue extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            $sql = "CREATE OR REPLACE VIEW {{%overdue}} AS "
                    . "SELECT c.bibid, c.id, m.id as mbr_id, c.barcode_nmbr, "
                    . "concat_ws(' ', b.call_nmbr1, b.call_nmbr2, b.call_nmbr3) as callno, "
                    . "b.title, b.author, c.status_begin_dt, "
                    . "c.due_back_dt, "
                    . "concat(m.last_name, ', ', m.first_name) full_name, "
                    . "floor(to_days(now())-to_days(c.due_back_dt)) days_late "
                    . "FROM {{%biblio}} b "
                    . "LEFT JOIN {{%biblio_copy}} c ON b.id = c.bibid "
                    . "LEFT JOIN {{%member}} m ON c.mbr_id = m.id "
                    . "WHERE c.status_cd = 'out';";
        } elseif ($this->db->driverName === 'pgsql') {
            $sql = "CREATE OR REPLACE VIEW {{%overdue}} AS "
                    . "SELECT c.bibid, c.id, m.id as mbr_id, c.barcode_nmbr, "
                    . "concat_ws(' ', b.call_nmbr1, b.call_nmbr2, b.call_nmbr3) as callno, "
                    . "b.title, b.author, c.status_begin_dt, "
                    . "c.due_back_dt, "
                    . "concat(m.last_name, ', ', m.first_name) full_name, "
                    . "floor(EXTRACT(DAY FROM CURRENT_DATE) - EXTRACT(DAY FROM c.due_back_dt)) days_late "
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
        $this->db->createCommand("drop view if exists {{%overdue}}")->execute();
        return true;
    }

    protected function isPostgreSQL() {
        return $this->db->driverName === 'pgsql';
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171229_193919_create_view_overdue cannot be reverted.\n";

      return false;
      }
     */
}
