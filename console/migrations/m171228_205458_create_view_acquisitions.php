<?php

use yii\db\Migration;

/**
 * Class m171228_205458_create_view_acquisitions
 */
class m171228_205458_create_view_acquisitions extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $sql = "
            create or replace view {{%acquisitions}} as
                select distinct b.id,
                    b.created_at, b.title, b.author,
                    coll.description as collection, mat.description as Material,
                    (select count(*) from biblio_copy where bibid = b.id) as \"Num of Copies\"
                from {{%biblio}} b
                left join {{%biblio_copy}} c on b.id = c.bibid
                left join {{%material_type_dm}} mat on mat.id = b.material_cd
                left join {{%collection_dm}} coll on coll.id = b.collection_cd
            ;";
        $this->db->createCommand($sql)->execute();
        
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->db->createCommand("drop view if exists {{%acquisitions}}")->execute();
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171228_205458_create_view_acquisitions cannot be reverted.\n";

      return false;
      }
     */
}
