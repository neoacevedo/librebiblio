<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioCopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/settings', 'Library Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-create">

    <div class="card">
        <div class="card-body">
            <?php echo $this->render('_form', ['model' => $model, 'files' => $files]); ?>
        </div>
    </div>
</div>