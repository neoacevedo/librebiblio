<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%biblio_status_hist}}`.
 */
class m240301_165931_add_id_column_to_biblio_status_hist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%biblio_status_hist}}', 'id', $this->primaryKey()->first());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%biblio_status_hist}}', 'id');
    }
}
