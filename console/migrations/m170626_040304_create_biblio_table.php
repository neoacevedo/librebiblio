<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio`.
 */
class m170626_040304_create_biblio_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable("{{%biblio}}", [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'updated_userid' => $this->integer()->notNull(),
            'material_cd' => $this->smallInteger()->notNull(),
            'collection_cd'=> $this->smallInteger()->notNull(),
            'call_nmbr1' => $this->string(20),
            'call_nmbr2' => $this->string(20),
            'call_nmbr3' => $this->string(20),
            'title' => $this->text(),
            'title_remainder' => $this->text(),
            'responsibility_stmt' => $this->text(),
            'author' => $this->text(),
            'topic1' => $this->text(),
            'topic2' => $this->text(),
            'topic3' => $this->text(),
            'topic4' => $this->text(),
            'topic5' => $this->text(),
            'opac_flg' => $this->char(1)->notNull()
        ]);
        
        // creates index for column `author_id`
        $this->createIndex(
            'idx-biblio-userid',
            '{{%biblio}}',
            'updated_userid'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-biblio-userid',
            '{{%biblio}}',
            'updated_userid',
            '{{%user}}',
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
            'fk-biblio-userid',
            '{{%biblio}}'
        );
        $this->dropTable('{{%biblio}}');
    }
}
