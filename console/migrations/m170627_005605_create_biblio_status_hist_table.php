<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio_status_hist`.
 * Has foreign keys to the tables:
 *
 * - `biblio`
 * - `biblio_copy`
 * - `user`
 */
class m170627_005605_create_biblio_status_hist_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%biblio_status_hist}}', [
            'bibid' => $this->integer()->notNull(),
            'copyid' => $this->integer()->notNull(),
            'status_cd' => $this->string(3)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'due_back_dt' => $this->date(),
            'mbr_id' => $this->integer()->notNull(),
            'renewal_count' => $this->smallInteger()->unsigned(),
        ]);
        
        // add primary keys
        $this->addPrimaryKey('biblio_status_hist_pk', '{{%biblio_status_hist}}', ['bibid', 'copyid']);


        // creates index for column `bibid`
        $this->createIndex(
            'idx-biblio_status_hist-bibid',
            '{{%biblio_status_hist}}',
            'bibid'
        );

        // add foreign key for table `biblio`
        $this->addForeignKey(
            'fk-biblio_status_hist-bibid',
            '{{%biblio_status_hist}}',
            'bibid',
            'biblio',
            'id',
            'CASCADE'
        );

        // creates index for column `copyid`
        $this->createIndex(
            'idx-biblio_status_hist-copyid',
            '{{%biblio_status_hist}}',
            'copyid'
        );

        // add foreign key for table `biblio_copy`
        $this->addForeignKey(
            'fk-biblio_status_hist-copyid',
            '{{%biblio_status_hist}}',
            'copyid',
            'biblio_copy',
            'id',
            'CASCADE'
        );

        // creates index for column `mbr_id`
        $this->createIndex(
            'idx-biblio_status_hist-mbr_id',
            '{{%biblio_status_hist}}',
            'mbr_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-biblio_status_hist-mbr_id',
            '{{%biblio_status_hist}}',
            'mbr_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `biblio`
        $this->dropForeignKey(
            'fk-biblio_status_hist-bibid',
            '{{%biblio_status_hist}}'
        );

        // drops index for column `bibid`
        $this->dropIndex(
            'idx-biblio_status_hist-bibid',
            '{{%biblio_status_hist}}'
        );

        // drops foreign key for table `biblio_copy`
        $this->dropForeignKey(
            'fk-biblio_status_hist-copyid',
            '{{%biblio_status_hist}}'
        );

        // drops index for column `copyid`
        $this->dropIndex(
            'idx-biblio_status_hist-copyid',
            '{{%biblio_status_hist}}'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-biblio_status_hist-mbr_id',
            '{{%biblio_status_hist}}'
        );

        // drops index for column `mbr_id`
        $this->dropIndex(
            'idx-biblio_status_hist-mbr_id',
            '{{%biblio_status_hist}}'
        );

        $this->dropTable('{{%biblio_status_hist}}');
    }
}
