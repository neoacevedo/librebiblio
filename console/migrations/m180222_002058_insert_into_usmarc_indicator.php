<?php

use yii\db\Migration;

/**
 * Class m180222_002058_insert_into_usmarc_indicator
 */
class m180222_002058_insert_into_usmarc_indicator extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/usmarc_indicator_dm.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es-CO/usmarc_indicator_dm.sql");
        }
        $this->execute($sql);
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
        echo "m180222_002058_insert_into_usmarc_indicator cannot be reverted.\n";

        return false;
    }
    */
}
