<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
$this->title = Yii::t('app/report', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <?php
        echo Yii::t('app/report', 'Choose from one of the following links to run a report.');

        foreach (array_keys($objects) as $category):
            ?>
            <ul>
                <li><h4><?= Yii::t('app', $category) ?></h4>
                    <ul>
                        <?php
                        foreach ($objects[$category] as $object):
                            if (null !== $object->title) :
                                ?>
                        <li><?= Html::a(Yii::t('app/report', $object->title), ["admin/report/". strtolower(str_replace(" ", "_", $object->title))]) ?></li>
                                <?php
                            endif;
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

