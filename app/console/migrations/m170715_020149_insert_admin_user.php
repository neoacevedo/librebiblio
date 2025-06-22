<?php

use yii\db\Migration;

class m170715_020149_insert_admin_user extends Migration {

    /**
     * URL para obtener la información de la instancia de Amazon.
     * @var string 
     */
    private $curl_url = "http://169.254.169.254/latest/meta-data/instance-id";

    public function safeUp() {
        // obtener el id de la instancia
        $instance_id = $this->getInstanceId();

        $password_hash = ($instance_id !== false) ? Yii::$app->security->generatePasswordHash($instance_id) :
                Yii::$app->security->generatePasswordHash('admin');

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'address' => 'Calle Falsa 123',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => $password_hash,
            'email' => 'admin@localhost.co',
            'phone' => '+573999999999',
            'status' => 10,
            'created_at' => strtotime("now"),
            'updated_at' => strtotime("now")
        ]);
    }

    private function getInstanceId() {
        $session = curl_init($this->curl_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($session, CURLOPT_TIMEOUT, 2);
        $response = curl_exec($session);
        return $response;
    }

    public function safeDown() {
        return true;
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
