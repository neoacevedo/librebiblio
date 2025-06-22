<?php

use Mpdf\QrCode\Output\Svg;
use Mpdf\QrCode\QrCode;
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

        $qrCode = new QrCode("{$model->biblio->title}\\n{$model->biblio->author}\\n{$model->barcode_nmbr}");
        $output = new Svg();

        $qrSvg = $output->output($qrCode, 100);

        // Remove special comments
        $qrSvg = str_replace('<?xml version="1.0"?>', '', $qrSvg);

        $html .= '<td colspan="4">'
                . "    <p>&nbsp;</p>"
                . "    <p><center>$qrSvg</center></p>"
                . "    <p><center>{$model->barcode_nmbr}</center></p>"
                . "    <p>&nbsp;</p>"
                . "</td>";

        return $html;
    },
    'itemOptions' => [
        'tag' => 'tr',
    ],
]);
