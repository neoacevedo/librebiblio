<?php

use yii\db\Migration;

/**
 * Class m180210_022656_insert_auth_assignment_for_admin_user
 */
class m180210_022656_insert_auth_assignment_for_admin_user extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $this->insert($authManager->assignmentTable, [
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => strtotime("now"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        return true;
    }

    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager() {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180105_212344_insert_auth_assignment_for_admin_user cannot be reverted.\n";

      return false;
      }
     */
}
