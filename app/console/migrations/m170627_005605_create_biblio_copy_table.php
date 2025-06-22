<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio_copy`.
 */
class m170627_005605_create_biblio_copy_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('{{%biblio_copy}}', [
            'id' => $this->integer()->notNull(),
            'bibid' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'copy_desc' => $this->string(160),
            'barcode_nmbr' => $this->string(20)->notNull(),
            'status_cd' => $this->char(3)->notNull(),
            'status_begin_dt' => $this->dateTime()->notNull(),
            'due_back_dt' => $this->dateTime(),
            'mbr_id' => $this->integer(),
            'renewal_count' => $this->smallInteger()->unsigned()->defaultValue(0),
        ]);

        // add primary keys
        $this->addPrimaryKey('bibliocopy_pk', '{{%biblio_copy}}', ['id', 'bibid']);

        // alter id to autoincrement
        if ($this->db->driverName === 'mysql') {
            $this->alterColumn('{{%biblio_copy}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        } elseif ($this->db->driverName === 'pgsql') {
            $this->db->createCommand("CREATE SEQUENCE IF NOT EXISTS biblio_copy_id_seq;")->execute();
            $this->alterColumn('{{%biblio_copy}}', 'id', "SET DEFAULT nextval('biblio_copy_id_seq')");
        }

        // creates index for column `barcode_mbr`
        $this->createIndex(
                'idx-barcode_nmbr', '{{%biblio_copy}}', 'barcode_nmbr'
        );

        // creates index for column `mbr_id`
        $this->createIndex(
                'idx-mbr_id', '{{%biblio_copy}}', 'mbr_id'
        );

        // add foreign key for table `biblio`
        $this->addForeignKey(
                'fk-biblio_copy-biblio', '{{%biblio_copy}}', 'bibid', '{{%biblio}}', 'id', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down() {
        // drops foreign key for table `biblio`
        $this->dropForeignKey(
                'fk-biblio_copy-biblio', '{{%biblio_copy}}'
        );
        
        /*if ($this->db->driverName === 'pgsql') {
            $this->db->createCommand("DROP SEQUENCE biblio_copy_id_seq;")->execute();
        }*/
        
        $this->dropTable('{{%biblio_copy}}');
    }

}
