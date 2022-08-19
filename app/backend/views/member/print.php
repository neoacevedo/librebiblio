<?php

use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="row">
    <div class="col-md-12">
        <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'options' => [
                'tag' => 'table',
                'class' => 'table table-bordered',
                'style' => 'width: 40%; margin-left: auto; margin-right: auto;'
            ],
            'itemView' => function ($model, $key, $index, $widget) {
                return "<tr>"
                        . "<td colspan='2' style='text-align: center;'>"
                        . "<span style='font-weight: bolder; font-size: 24px;'>" . Yii::$app->name . "</span></td>"
                        . "</tr>"
                        . "<tr>"
                        . "<td style='border-left: none; border-right: none;'>"
                        . "&nbsp;&nbsp;<strong>{$model->first_name} {$model->last_name}</strong>"
                        . "<p>&nbsp;</p>"
                        . "<p>&nbsp;</p>"
                        . "<p>&nbsp;</p>"
                        . "&nbsp;&nbsp;<strong>{$model->pin}</strong>"
                        . "</td>"
                        . "<td style='width: auto; border-left: none; border-right: none;'><barcode code=\"{$model->first_name} {$model->last_name}\\n{$model->pin}\" type=\"QR\" class=\"barcode\" size=\"0.85\" error=\"M\" />"
                        . "</td></tr>"
                        . "<tr>"
                        . "<td colspan='2' style='border: 0'><hr /></td>"
                        . "</tr>";
            },
            'itemOptions' => [
                'tag' => false,
            ],
        ]);
?>
    </div>
</div>