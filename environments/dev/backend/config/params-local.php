<?php
return [
    'pagination' => call_user_func(function() {
                try {
                    $db = array_shift(Yii::$app->db);
                    $connection = new \yii\db\Connection($db);
                    $connection->open();
                    $items_per_page = $connection->createCommand("Select items_per_page from {{%settings}}")->cache(3600)->queryOne()['items_per_age'];
                } catch (Exception $ex) {
                    $items_per_page = 20;
                }
                return $items_per_page;
            }),
];
