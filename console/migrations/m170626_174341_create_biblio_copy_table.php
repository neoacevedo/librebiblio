<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio_copy`.
 */
class m170626_174341_create_biblio_copy_table extends Migration {

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
            'status_begint_dt' => $this->dateTime()->notNull(),
            'due_back_dt' => $this->dateTime(),
            'mbr_id' => $this->integer(),
            'renewal_count' => $this->smallInteger()->unsigned()->notNull(),
        ]);

        // add primary keys
        $this->addPrimaryKey('bibliocopy_pk', '{{%biblio_copy}}', ['id', 'bibid']);

        // alter id to autoincrement
        $this->alterColumn('{{%biblio_copy}}', 'id', $this->integer().' NOT NULL AUTO_INCREMENT');
        
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
            'fk-biblio_copy-biblio',
            '{{%biblio_copy}}'
        );
        $this->dropTable('{{%biblio_copy}}');
    }

}
