<?php

use yii\db\Migration;

/**
 * Class m220826_165435_alter_created_at_and_updated_at_columns_from_biblio_table
 */
class m220826_165435_alter_created_at_and_updated_at_columns_from_biblio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("{{%biblio}}", "created_at", $this->integer()->notNull());
        $this->alterColumn("{{%biblio}}", "updated_at", $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220826_165435_alter_created_at_and_updated_at_columns_from_biblio_table cannot be reverted.\n";

        return false;
    }
    */
}
