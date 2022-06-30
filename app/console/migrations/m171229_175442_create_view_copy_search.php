<?php

use yii\db\Migration;

/**
 * Class m171229_175442_create_view_copy_search
 */
class m171229_175442_create_view_copy_search extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $sql = "CREATE OR REPLACE VIEW {{%copy_search}} AS "
                . "SELECT c.id, c.barcode_nmbr, c.created_at, concat_ws(' ', b.call_nmbr1, b.call_nmbr2, b.call_nmbr3) callno, "
                . "b.title, b.author, coll.description collection "
                . "FROM {{%biblio_copy}} c "
                . "LEFT JOIN {{%biblio}} b ON b.id = c.bibid "
                . "LEFT JOIN {{%collection_dm}} coll ON coll.id = b.collection_cd;";
        
        $this->db->createCommand($sql)->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->db->createCommand("drop view if exists {{%copy_search}}")->execute();
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171229_175442_create_view_copy_search cannot be reverted.\n";

      return false;
      }
     */
}
