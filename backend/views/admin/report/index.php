<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
$this->title = Yii::t('app/report', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        $this->render("../_sidenav");
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <?php
        echo Yii::t('app/report', 'Choose from one of the following links to run a report.');

        foreach (array_keys($objects) as $category) :
            ?>
            <ul>
                <li>
                    <h5><?= $category ?></h5>
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
        ?>
    </div>
</div>

