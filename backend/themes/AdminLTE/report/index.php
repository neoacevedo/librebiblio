<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
$this->title = Yii::t('app/reports', 'Reports');
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
        echo Yii::t('app/reports', 'Choose from one of the following links to run a report.');

        foreach ($objects as $object):
            ?>
            <ul>
                <li><h5><?= $object->category ?></h5></li>
                <li><ul><li></li></ul></li>
            </ul>
            <?php
        endforeach;
        ?>
    </div>
</div>

