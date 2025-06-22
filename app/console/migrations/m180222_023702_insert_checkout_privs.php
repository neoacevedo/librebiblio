<?php

use yii\db\Migration;

/**
 * Class m180222_023702_insert_checkout_privs
 */
class m180222_023702_insert_checkout_privs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/checkout_privs.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es/checkout_privs.sql");
        }
        if ($this->db->driverName === "mysql") {
            $this->db->createCommand($sql)->execute();
        } elseif ($this->db->driverName === "pgsql") {
            $sql_array = explode(";", $sql);
            foreach ($sql_array as $sql) {
                $this->db->createCommand($sql)->execute();
                // incrementar la secuencia MANUALMENTE
                $this->db->createCommand("SELECT setval('checkout_privs_id_seq', (SELECT MAX(id) from {{%checkout_privs}}));")->execute();
            }
        }
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180222_023702_insert_checkout_privs cannot be reverted.\n";

        return false;
    }
    */
}
