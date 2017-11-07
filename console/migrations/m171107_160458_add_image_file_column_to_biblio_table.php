<?php

use yii\db\Migration;

/**
 * Handles adding image_file to table `biblio`.
 */
class m171107_160458_add_image_file_column_to_biblio_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%biblio}}', 'image_file', $this->string(128)->after("title_remainder"));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('biblio', 'image_file');
    }
}
