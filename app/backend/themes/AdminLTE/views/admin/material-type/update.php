<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\MaterialType */
/** @var array $material_type_list */
/** @var yii\web\UploadedFile $fileModel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Material Type',
        ]) . $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Material Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
$js = <<<JS
(function() {
    if(document.getElementById("materialtype-icon").value != "") {
        document.getElementById("filemanager-uploadedfile").disabled = true;
    }
    document.getElementById("materialtype-icon").addEventListener('change', (event) => {
        if(event.target.value == "") {
            document.getElementById("filemanager-uploadedfile").disabled = false;
        } else {
            document.getElementById("filemanager-uploadedfile").disabled = true;
        }
    });
})();
JS;

$this->registerJs($js, View::POS_END);
?>
<div class="material-type-update">
    <div class="card">
        <div class="card-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                "material_type_list" => $material_type_list,
                'fileModel' => $fileModel
            ])
            ?>
        </div>
    </div>
</div>