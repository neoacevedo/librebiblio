<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio_field`.
 * Has foreign keys to the tables:
 *
 * - `biblio`
 */
class m170627_011354_create_biblio_field_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%biblio_field}}', [
            'id' => $this->integer()->notNull(),
            'bibid' => $this->integer()->notNull(),
            'tag' => $this->smallInteger()->notNull(),
            'ind1_cd' => $this->char(1),
            'ind2_cd' => $this->char(1),
            'subfield_cd' => $this->char(1)->notNull(),
            'field_data' => $this->text(),
        ]);
        
        // add primary keys
        $this->addPrimaryKey('bibliofield_pk', '{{%biblio_field}}', ['id', 'bibid']);

        // alter id to autoincrement
        $this->alterColumn('{{%biblio_field}}', 'id', $this->integer().' NOT NULL AUTO_INCREMENT');

        // creates index for column `bibid`
        $this->createIndex(
            'idx-biblio_field-bibid',
            'biblio_field',
            'bibid'
        );

        // add foreign key for table `biblio`
        $this->addForeignKey(
            'fk-biblio_field-bibid',
            'biblio_field',
            'bibid',
            'biblio',
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
            'fk-biblio_field-bibid',
            '{{%biblio_field}}'
        );

        // drops index for column `bibid`
        $this->dropIndex(
            'idx-biblio_field-bibid',
            '{{%biblio_field}}'
        );

        $this->dropTable('{{%biblio_field}}');
    }
}
