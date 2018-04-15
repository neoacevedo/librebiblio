<?php

use yii\db\Migration;

/**
 * Handles the creation of table `checkout_privs`.
 */
class m170809_043857_create_checkout_privs_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('{{%checkout_privs}}', [
            'id' => $this->integer()->notNull(),
            'material_cd' => $this->integer()->notNull(),
            'classification_id' => $this->integer()->notNull(),
            'checkout_limit' => $this->smallInteger()->unsigned()->notNull(),
            'renewal_limit' => $this->smallInteger()->unsigned()->notNull(),
        ]);

        // add primary keys
        $this->addPrimaryKey('checkout_privs_pk', '{{%checkout_privs}}', ['id', 'material_cd', 'classification_id']);
        // alter id to autoincrement
        if ($this->db->driverName === 'mysql') {
            $this->alterColumn('{{%checkout_privs}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        } else if ($this->db->driverName === 'pgsql') {
            $this->db->createCommand("CREATE SEQUENCE IF NOT EXISTS checkout_privs_id_seq;")->execute();
            $this->alterColumn('{{%biblio_hold}}', 'id', "SET DEFAULT nextval('checkout_privs_id_seq')");
        }

        // creates index for column `material_cd`
        $this->createIndex(
                'idx-checkout_privs-material_cd', '{{%checkout_privs}}', 'material_cd'
        );

        // creates index for column `classification_id`
        $this->createIndex(
                'idx-checkout_privs-classification_id', '{{%checkout_privs}}', 'classification_id'
        );

        // add foreign key for table `material_type_dm`
        $this->addForeignKey(
                'fk-checkout_privs-material_cd', '{{%checkout_privs}}', 'material_cd', '{{%material_type_dm}}', 'id', 'CASCADE'
        );

        // add foreign key for table `mbr_classify_dm`
        $this->addForeignKey(
                'fk-checkout_privs-classification_id', '{{%checkout_privs}}', 'classification_id', '{{%mbr_classify_dm}}', 'id', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        // drops foreign key for table `mbr_classify_dm`
        $this->dropForeignKey(
                'fk-checkout_privs-classification_id', '{{%checkout_privs}}'
        );

        // drops index for column `classification_id`
        $this->dropIndex(
                'idx-checkout_privs-classification_id', '{{%checkout_privs}}'
        );

        // drops foreign key for table `material_type_dm`
        $this->dropForeignKey(
                'fk-checkout_privs-material_cd', '{{%checkout_privs}}'
        );

        // drops index for column `material_cd`
        $this->dropIndex(
                'idx-checkout_privs-material_cd', '{{%checkout_privs}}'
        );


        $this->dropTable('{{%checkout_privs}}');
    }

}
