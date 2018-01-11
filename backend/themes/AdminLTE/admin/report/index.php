<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app/reports', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-12 col-md-12col-sm-12">
        <?php
        echo Yii::t('app/reports', 'Choose from one of the following links to run a report.');
        echo '<div class="box box-primary">';
        foreach (array_keys($objects) as $category) :
            ?>
            <ul>
                <li>
                    <h4><?= Yii::t('app', $category) ?></h4>
                    <ul>
                        <?php
                        foreach ($objects[$category] as $report) :
                            ?>
                            <li><?= Html::a(Yii::t('app/reports', $report->name), \yii\helpers\Url::toRoute(["admin/report/search", "type" => $report->formName()])) ?></li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </li>
            </ul>
            <?php
        endforeach;
        echo '</div>';
        ?>
    </div>
</div>

