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
    public function safeUp()
    {
        $this->createTable('{{%biblio_field}}', [
            'bibid' => $this->integer()->notNull(),
            'fieldid' => $this->integer()->notNull(),
            'tag' => $this->smallInteger()->notNull(),
            'ind1_cd' => $this->char(1)->defaultValue('N'),
            'ind2_cd' => $this->char(1)->defaultValue('N'),
            'subfield_cd' => $this->char(1)->notNull(),
            'field_data' => $this->text(),
        ]);
        
        // add primary keys
        $this->addPrimaryKey('bibliofield_pk', '{{%biblio_field}}', ['bibid', 'fieldid']);
        
        // creates index for column `bibid`
        $this->createIndex(
            'idx-biblio_field-bibid',
            'biblio_field',
            'bibid'
        );
        
        // creates index for column `fieldid`
        $this->createIndex(
            'idx-biblio_field-fieldid',
            'biblio_field',
            'fieldid'
        );

        // alter id to autoincrement
        if ($this->db->driverName === 'mysql') {
            $this->alterColumn('{{%biblio_field}}', 'fieldid', $this->integer().' NOT NULL AUTO_INCREMENT');
        } elseif ($this->db->driverName === 'pgsql') {
            $this->db->createCommand("CREATE SEQUENCE IF NOT EXISTS biblio_field_fieldid_seq;")->execute();
            $this->alterColumn('{{%biblio_field}}', 'fieldid', "SET DEFAULT nextval('biblio_field_fieldid_seq')");
        }

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
    public function safeDown()
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
        
        // drops index for column `fieldid`
        $this->dropIndex(
            'idx-biblio_field-fieldid',
            '{{%biblio_field}}'
        );

        $this->dropTable('{{%biblio_field}}');
    }
}
