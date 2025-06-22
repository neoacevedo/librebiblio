<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio_hold`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m170627_000312_create_biblio_hold_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('{{%biblio_hold}}', [
            'id' => $this->integer()->notNull(),
            'bibid' => $this->integer()->notNull(),
            'copyid' => $this->integer()->notNull(),
            'hold_begin_dt' => $this->dateTime()->notNull(),
            'mbr_id' => $this->integer(),
        ]);

        // add primary keys
        $this->addPrimaryKey('bibliohold_pk', '{{%biblio_hold}}', ['id', 'bibid', 'copyid']);

        // alter id to autoincrement
        if ($this->db->driverName === 'mysql') {
            $this->alterColumn('{{%biblio_hold}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        } elseif ($this->db->driverName === 'pgsql') {
            $this->db->createCommand("CREATE SEQUENCE IF NOT EXISTS biblio_hold_id_seq;")->execute();
            $this->alterColumn('{{%biblio_hold}}', 'id', "SET DEFAULT nextval('biblio_hold_id_seq')");
        }
        // creates index for column `mbr_id`
        $this->createIndex(
                'idx-biblio_hold-mbr_id', '{{%biblio_hold}}', 'mbr_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
                'fk-biblio_hold-mbr_id', '{{%biblio_hold}}', 'mbr_id', '{{%member}}', 'id', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        // drops foreign key for table `user`
        $this->dropForeignKey(
                'fk-biblio_hold-mbr_id', '{{%biblio_hold}}'
        );

        // drops index for column `mbr_id`
        $this->dropIndex(
                'idx-biblio_hold-mbr_id', '{{%biblio_hold}}'
        );
        
        /*if ($this->db->driverName === 'pgsql') {
            $this->db->createCommand("DROP SEQUENCE biblio_hold_id_seq;")->execute();
        }*/

        $this->dropTable('{{%biblio_hold}}');
    }

}
