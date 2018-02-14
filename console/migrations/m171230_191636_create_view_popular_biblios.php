<?php

use yii\db\Migration;

/**
 * Class m171230_191636_create_view_popular_biblios
 */
class m171230_191636_create_view_popular_biblios extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $sql = "CREATE OR REPLACE VIEW {{%popular_biblios}} AS "
                . "SELECT b.id, c.barcode_nmbr, b.title, b.author, "
                . "count(h.created_at) checkoutCount "
                . "FROM {{%biblio_status_hist}} h "
                . "LEFT JOIN {{%biblio_copy}} c ON h.bibid = c.bibid AND h.copyid = c.id "
                . "LEFT JOIN {{%biblio}} b ON h.bibid = b.id "
                . "WHERE h.status_cd = 'out';";        
        $this->db->createCommand($sql)->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->db->createCommand("drop view if exists {{%popular_biblios}}")->execute();
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171230_191636_create_view_popular_biblios cannot be reverted.\n";

        return false;
    }
    */
}
