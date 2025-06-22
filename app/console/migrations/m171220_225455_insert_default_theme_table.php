<?php

use yii\db\Migration;

/**
 * Class m171220_225455_insert_default_theme_table
 */
class m171220_225455_insert_default_theme_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        // backend
        $this->insert('{{%theme}}', [
            'name' => 'AdminLTE',
            'active' => 1,
            'frontend' => 0,
            'skin' => 'blue',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // frontend
        $this->insert('{{%theme}}', [
            'name' => 'simple',
            'active' => 1,
            'frontend' => 1,
            'skin' => '',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        Yii::$app->db->createCommand()->truncateTable('{{%theme}}')->execute();
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171220_225455_insert_default_theme_table cannot be reverted.\n";

      return false;
      }
     */
}
