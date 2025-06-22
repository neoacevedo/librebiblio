<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app/reports', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
$i = 0;
?>
<div class="report-index">
    <h3><?= Yii::t('app/reports', 'Choose from one of the following links to run a report.') ?>
    </h3>
    <div class="row">
        <?php
            foreach (array_keys($reports) as $category) :
        ?>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4><?= Yii::t('app/reports', $category) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <ul>
                        <?php
                            foreach ($reports[$category] as $report) :
                        ?>
                        <li>
                            <?= Html::a(Yii::t("app/reports", $report->getName()), \yii\helpers\Url::toRoute(["admin/report/search", "type" => $report->formName()])) ?>
                        </li>
                        <?php
                            endforeach;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
            endforeach;
        ?>
    </div>
</div>