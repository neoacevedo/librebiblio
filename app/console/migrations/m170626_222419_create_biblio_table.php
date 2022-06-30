<?php

use yii\db\Migration;

/**
 * Handles the creation of table `biblio`.
 */
class m170626_222419_create_biblio_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
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
            'material_cd' => $this->integer()->notNull(),
            'collection_cd'=> $this->integer()->notNull(),
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
            'opac_flg' => $this->smallInteger(1)->notNull()
        ]);
        
        // creates index for column `updated_userid`
        $this->createIndex(
            'idx-biblio-userid',
            '{{%biblio}}',
            'updated_userid'
        );
        
        // creates index for column `material_cd`
        $this->createIndex(
            'idx-biblio-materialid',
            '{{%biblio}}',
            'material_cd'
        );
        
        // creates index for column `collection_cd`
        $this->createIndex(
            'idx-biblio-collectionid',
            '{{%biblio}}',
            'collection_cd'
        );
        
        // add foreign key for table `material_type_dm`
        $this->addForeignKey(
            'fk-biblio-materialid',
            '{{%biblio}}',
            'material_cd',
            '{{%material_type_dm}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
        
        // add foreign key for table `collection_dm`
        $this->addForeignKey(
            'fk-biblio-collectionid',
            '{{%biblio}}',
            'collection_cd',
            '{{%collection_dm}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-biblio-userid',
            '{{%biblio}}',
            'updated_userid',
            '{{%user}}',
            'id',
            'RESTRICT',
            'NO ACTION'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `biblio`
        $this->dropForeignKey(
            'fk-biblio-userid',
            '{{%biblio}}'
        );             
        
        $this->dropForeignKey(
            'fk-biblio-collectionid',
            '{{%biblio}}'
        );
        
        $this->dropForeignKey(
            'fk-biblio-materialid',
            '{{%biblio}}'
        );
        
        // drops index for column `updated_userid`
        $this->dropIndex(
            'idx-biblio-userid',
            '{{%biblio}}'
        );
        
        // drops index for column `material_cd`
        $this->dropIndex(
            'idx-biblio-materialid',
            '{{%biblio}}'
        );
        
        // drops index for column `collection_cd`
        $this->dropIndex(
            'idx-biblio-collectionid',
            '{{%biblio}}'
        );        
        
        $this->dropTable('{{%biblio}}');
    }
}
