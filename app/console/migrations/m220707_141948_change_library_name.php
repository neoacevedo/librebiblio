<?php

use yii\db\Migration;

/**
 * Class m220707_141948_change_library_name
 */
class m220707_141948_change_library_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update("{{%settings}}", ["library_name" => "LibreBiblio"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update("{{%settings}}", ["library_name" => "OpenBiblio2"]);
    }
}
