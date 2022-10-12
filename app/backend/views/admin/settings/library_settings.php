<?php

/* @var $this yii\web\View */
/** @var array $files */
/** @var neoacevedo\yii2\storage\models\FileManager $fileModel */


$this->title = Yii::t('app/settings', 'Library Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-create">

    <div class="card">
        <div class="card-body">
            <?php echo $this->render('_form', ['model' => $model, 'files' => $files, "fileModel" => $fileModel]); ?>
        </div>
    </div>
</div>