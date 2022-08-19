<?php

use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'options' => [
      'tag' => 'table',
      'class' => 'table table-bordered',
      //'style' => 'margin-left: auto; margin-right: auto;'
      ],
    'itemView' => function ($model, $key, $index, $widget) {
        $html = "";
        if (($index % 5 === 0)) {
            $html .= "<tr>";
        }

        $html .= "<td>"
                . "   <p>&nbsp;</p>"
                . "    <p>&nbsp;</p>"
                . "   <barcode code=\"{$model->biblio->title}\\n{$model->biblio->author}\\n{$model->barcode_nmbr}\" type=\"QR\" class=\"barcode\" size=\"0.85\" error=\"M\" />"
                . "   <p><center>{$model->barcode_nmbr}</center></p>"
                . "    <p>&nbsp;</p>"
                . "</td>";
        if (($index > 0) && ($index % 5 === 0)) {
            $html .= "</tr>";
        }

        return $html;
    },
    'itemOptions' => [
        'tag' => false,
    ],
]);
