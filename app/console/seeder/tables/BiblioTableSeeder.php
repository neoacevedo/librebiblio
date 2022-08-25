<?php

namespace console\seeder\tables;

use antonyz89\seeder\TableSeeder;
use console\seeder\DatabaseSeeder;
use common\models\Biblio;

/**
 * Handles the creation of seeder `{{%biblio}}`.
 */
class BiblioTableSeeder extends TableSeeder
{
    /**
     * {@inheritdoc}
     */
    function run()
    {
        loop(function ($i) {
            $this->insert(Biblio::tableName(), [
                'updated_userid' => $this->faker->numberBetween(0, 10),
				'material_cd' => $this->faker->numberBetween(0, 10),
				'collection_cd' => $this->faker->numberBetween(0, 10),
				'call_nmbr1' => $this->faker->text,
				'call_nmbr2' => $this->faker->text,
				'call_nmbr3' => $this->faker->text,
				'title' => $this->faker->text,
				'title_remainder' => $this->faker->text,
				'image_file' => $this->faker->text,
				'responsibility_stmt' => $this->faker->text,
				'author' => $this->faker->text,
				'topic1' => $this->faker->text,
				'topic2' => $this->faker->text,
				'topic3' => $this->faker->text,
				'topic4' => $this->faker->text,
				'topic5' => $this->faker->text,
				'opac_flg' => $this->faker->numberBetween(0, 10),
            ]);
        }, DatabaseSeeder::BIBLIO_COUNT);
    }
}
