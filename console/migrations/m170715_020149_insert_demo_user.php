<?php

use yii\db\Migration;

class m170715_020149_insert_demo_user extends Migration
{
    public function safeUp()
    {

	$this->insert('user', [
            'username' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'email' => 'nestor.acevedo.romero@gmail.com',
            'status' => 10,
            'created_at' => strtotime("now"),
            'updated_at' => strtotime("now")
        ]);
    }

    public function safeDown()
    {
        echo "m170715_020149_insert_demo_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170715_020149_insert_demo_user cannot be reverted.\n";

        return false;
    }
    */
}
