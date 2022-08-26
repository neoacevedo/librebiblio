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
    public function run()
    {
        $biblios = [
            [
                "updated_userid" => 1,
                "material_cd" => 2, // libros
                "collection_cd" => 2, // no ficción para adultos
                "call_nmbr1" => "005.4",
                "call_nmbr2" => "Lar",
                "call_nmbr3" => "",
                "title" => "Applying UML and Patterns",
                "title_remainder" => "An Introduction to Object Oriented Analysis and Design",
                "image_file" => "",
                "responsibility_stmt" => "Craig Larman",
                "author" => "Larman, Craig",
                "topic1", "Object-Oriented",
                "topic2" => "Programming",
                "topic3" => "Software Design",
                "topic4" => "UML",
                "topic5" => "",
                "opac_flg" => 1
            ],
            [
                "updated_userid" => 1,
                "material_cd" => 2, // libros
                "collection_cd" => 2, // no ficción para adultos
                "call_nmbr1" => "005.4",
                "call_nmbr2" => "Gam",
                "call_nmbr3" => "",
                "title" => "Design Patterns",
                "title_remainder" => "Elements of Reusable Object-Oriented Software",
                "image_file" => "",
                "responsibility_stmt" => "Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides",
                "author" => "Gamma, Erich",
                "topic1" => "Object-Oriented",
                "topic2" => "Programming",
                "topic3" => "Software Design",
                "topic4" => "",
                "topic5" => "",
                "opac_flg" => 1
            ],
            [
                "updated_userid" => 1,
                "material_cd" => 2, // libros
                "collection_cd" => 7, // ficción juvenil
                "call_nmbr1" => "JF",
                "call_nmbr2" => "Cle",
                "call_nmbr3" => "",
                "title" => "Henry Huggins",
                "title_remainder" => "",
                "image_file" => "",
                "responsibility_stmt" => "Beverly Cleary, Illustrated by Louis Darling",
                "author" => "Cleary, Beverly",
                "topic1" => "finction",
                "topic2" => "dogs",
                "topic3" => "",
                "topic4" => "",
                "topic5" => "",
                "opac_flg" => 1
            ],
            [
                "updated_userid" => 1,
                "material_cd" => 2, // libros
                "collection_cd" => 2, // no ficción para adultos
                "call_nmbr1" => "005.4",
                "call_nmbr2" => "Fla",
                "call_nmbr3" => "",
                "title" => "Java in a Nutshell",
                "title_remainder" => "A Desktop Quick Reference",
                "image_file" => "",
                "responsibility_stmt" => "David Lanagan",
                "author" => "Flanagan, David",
                "topic1" => "Java",
                "topic2" => "Computers",
                "topic3" => "Programming",
                "topic4" => "Programming Languages",
                "topic5" => "",
                "opac_flg" => 1
            ],
            [
                "updated_userid" => 1,
                "material_cd" => 6, // revistas
                "collection_cd" => 9, // periódicos
                "call_nmbr1" => "P",
                "call_nmbr2" => "PCW",
                "call_nmbr3" => "",
                "title" => "PC World (Periodical):2003",
                "title_remainder" => "",
                "image_file" => "",
                "responsibility_stmt" => "",
                "author" => "PC World Communications, Inc",
                "topic1" => "Computers",
                "topic2" => "Personal Computing",
                "topic3" => "Periodicals",
                "topic4" => "",
                "topic5" => "",
                "opac_flg" => 1
            ],
            [
                "updated_userid" => 1,
                "material_cd" => 2, // libros
                "collection_cd" => 7, // ficción juvenil
                "call_nmbr1" => "JF",
                "call_nmbr2" => "Cle",
                "call_nmbr3" => "",
                "title" => "Ribsy",
                "title_remainder" => "",
                "image_file" => "",
                "responsibility_stmt" => "Beverly Cleary, Illustrated by Louis Darling",
                "author" => "Cleary, Beverly",
                "topic1" => "fiction",
                "topic2" => "dogs",
                "topic3" => "",
                "topic4" => "",
                "topic5" => "",
                "opac_flg" => 1
            ],
            [
                "updated_userid" => 1,
                "material_cd" => 6, // revistas
                "collection_cd" => 9, // periódicos
                "call_nmbr1" => "P",
                "call_nmbr2" => "PCW",
                "call_nmbr3" => "",
                "title" => "U.S. News & World Report (Periodical):2003",
                "title_remainder" => "",
                "image_file" => "",
                "responsibility_stmt" => "",
                "author" => "U.S. News & World Report",
                "topic1" => "Periodicals",
                "topic2" => "News",
                "topic3" => "",
                "topic4" => "",
                "topic5" => "",
                "opac_flg" => 1
            ],
        ];

        loop(function ($i) use ($biblios) {
            $this->insert(Biblio::tableName(), [
                'updated_userid' => $biblios[$i]["updated_userid"],
                'material_cd' => $biblios[$i]["material_cd"],
                'collection_cd' => $biblios[$i]["collection_cd"],
                'call_nmbr1' => $biblios[$i]["call_nmbr1"],
                'call_nmbr2' => $biblios[$i]["call_nmbr2"],
                'call_nmbr3' => $biblios[$i]["call_nmbr3"],
                'title' => $biblios[$i]["title"],
                'title_remainder' => $biblios[$i]["title_remainder"],
                'image_file' => $biblios[$i]["image_file"],
                'responsibility_stmt' => $biblios[$i]["responsibility_stmt"],
                'author' => $biblios[$i]["author"],
                'topic1' => $biblios[$i]["topic1"],
                'topic2' => $biblios[$i]["topic2"],
                'topic3' => $biblios[$i]["topic3"],
                'topic4' => $biblios[$i]["topic4"],
                'topic5' => $biblios[$i]["topic5"],
                'opac_flg' => $biblios[$i]["opac_flg"],
            ]);
        }, count($biblios) - 1);
    }
}
