<?php

use yii\db\Migration;

/**
 * Handles adding pin to table `member`.
 */
class m180122_235806_add_pin_column_to_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%member}}', 'pin', $this->double()->unsigned()->unique()->notNull()->after("last_name"));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%member}}', 'pin');
    }
}
