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
    public function safeUp() {
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/checkout_privs.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es-CO/checkout_privs.sql");
        }
        $this->execute($sql);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180222_023702_insert_checkout_privs cannot be reverted.\n";

        return false;
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
