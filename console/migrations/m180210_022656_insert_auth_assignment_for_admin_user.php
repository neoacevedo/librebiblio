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
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/auth_item.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es-CO/auth_item.sql");
        }
        if ($this->db->driverName === "mysql") {
            $this->db->createCommand($sql)->execute();
        } else if ($this->db->driverName === "pgsql") {
            $sql_array = explode(";", $sql);
            foreach ($sql_array as $sql) {
                $this->db->createCommand($sql)->execute();;
            }
        }
        $this->insert('{{%auth_assignment}}', [
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
