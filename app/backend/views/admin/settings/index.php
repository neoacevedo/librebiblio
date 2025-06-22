<?php

use yii\helpers\Html;

//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioCopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings">
    <div class="card">
        <div class="card-body">
            <div class="col">
                <div class="content">
                    <h4><?= Html::encode(Yii::t('app/settings', 'Library Settings')) ?>
                    </h4>
                    <p><?= Html::encode(Yii::t('app/settings', 'Basic Library Settings.')) ?>
                    </p>
                    <h4><?= Html::encode(Yii::t('app/settings', 'Material Types')) ?>
                    </h4>
                    <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Material types for Library.')) ?>
                    </p>
                    <h4><?= Html::encode(Yii::t('app/settings', 'Collections')) ?>
                    </h4>
                    <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Bibliograhical Collections.')) ?>
                    </p>
                    <h4><?= Html::encode(Yii::t('app/settings', 'Member Classify')) ?>
                    </h4>
                    <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Classification for Library Members.')) ?>
                    </p>
                    <h4><?= Html::encode(Yii::t('app/settings', 'Checkout Privileges')) ?>
                    </h4>
                    <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Checkout for Library Members.')) ?>
                    </p>
                    <h4><?= Html::encode(Yii::t('app/settings', 'Themes')) ?>
                    </h4>
                    <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Themes.')) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>