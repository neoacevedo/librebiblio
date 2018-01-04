<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170626_040540_create_member_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('{{%member}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'phone' => $this->string(32)->notNull(),
            'classification_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `updated_userid`
        $this->createIndex(
                'fk_member_classification_idx', '{{%member}}', 'classification_id'
        );

        // add foreign key for table `material_type_dm`
        $this->addForeignKey(
                'fk_member_classification', '{{%member}}', 'classification_id', '{{%mbr_classify_dm}}', 'id', 'RESTRICT', 'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('{{%member}}');
    }

}
