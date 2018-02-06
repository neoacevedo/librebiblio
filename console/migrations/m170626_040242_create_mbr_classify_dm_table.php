<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mbr_classify`.
 */
class m170626_040242_create_mbr_classify_dm_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%mbr_classify_dm}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull()->defaultValue('N'),
            'max_fines' => $this->decimal(4,2)->notNull(),
        ]);
    }
    
    public function safeUp() {
        $language = str_replace("_", "-", locale_get_default());
        $sql = file_get_contents(Yii::getAlias("@console") . "/migrations/sql/$language/mbr_classify_dm.sql");
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%mbr_classify_dm}}');
    }
}
