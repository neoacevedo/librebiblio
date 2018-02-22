<?php

use yii\db\Migration;

/**
 * Class m180222_001727_insert_into_biblio_status
 */
class m180222_001727_insert_into_biblio_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $language = str_replace("_", "-", locale_get_default());
        try {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/biblio_status_dm.sql");
        } catch (Exception $ex) {
            $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/es-CO/biblio_status_dm.sql");
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
        echo "m180222_001727_insert_into_biblio_status cannot be reverted.\n";

        return false;
    }
    */
}
