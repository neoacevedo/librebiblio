<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mbr_classify`.
 */
class m170627_013949_create_mbr_classify_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%mbr_classify}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(40)->notNull(),
            'default_flg' => $this->char(1)->notNull(),
            'max_fines' => $this->decimal(4,2)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%mbr_classify}}');
    }
}
