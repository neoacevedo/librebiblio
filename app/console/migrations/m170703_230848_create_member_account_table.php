<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member_account`.
 */
class m170703_230848_create_member_account_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            $this->createTable('{{%member_account}}', [
                'id' => $this->integer()->notNull() . " AUTO_INCREMENT",
                'mbr_id' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'create_userid' => $this->integer()->notNull(),
                'transaction_type_cd' => $this->char(2)->notNull(),
                'amount' => $this->decimal(8, 2)->notNull(),
                'description' => $this->string(128),
                'PRIMARY KEY(id, mbr_id)',
            ]);
        } elseif ($this->db->driverName === 'pgsql') {
            $this->createTable('{{%member_account}}', [
                'id' => "SERIAL",
                'mbr_id' => $this->integer()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
                'create_userid' => $this->integer()->notNull(),
                'transaction_type_cd' => $this->char(2)->notNull(),
                'amount' => $this->decimal(8, 2)->notNull(),
                'description' => $this->string(128),
                'PRIMARY KEY(id, mbr_id)',
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('{{%member_account}}');
    }

}
