<?php

use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="row">
    <table class="table">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'options' => [
                'tag' => 'tr',
                'class' => 'fila',
            ],
            'itemView' => function ($model, $key, $index, $widget) {
                return '<table class="table table-bordered">'
                            . '<tr style="border: 1px solid #ddd;">'
                            . '    <td colspan="2" class="text-center" style="width: 100%; border-bottom: 1px solid #ddd;">'
                            . '        <h4>' . Yii::$app->name . '</h4>'
                            . '    </td>'
                            . "</tr>"
                            . '<tr>'
                            . '    <td class="col-6">'
                            . "        <p>&nbsp;</p>"
                            . '        <p><strong>' . "{$model->first_name}  {$model->last_name}" . '</strong></p>'
                            . "        <p>&nbsp;</p>"
                            . "        <p><strong>{$model->address}</strong></p>"
                            . "        <p>&nbsp;</p>"
                            . "        <p><strong>{$model->pin}</strong></p>"
                            . "        <p>&nbsp;</p>"
                            . "    </td>"
                            . '    <td class="col-6">'
                            . '        <barcode code="' . "{$model->first_name} {$model->last_name}\\n{$model->address}\\n{$model->pin}" . '" type="QR" class="barcode" size="0.8" error="M" />'
                            . "    </td>"
                            . '</tr>'
                    . '</table>';
            },
            'itemOptions' => [
                'tag' => 'td',
                'style' => 'width: 50%; padding: 15px; border: 1px dotted;'
            ],
        ]); ?>
    </table>
</div>