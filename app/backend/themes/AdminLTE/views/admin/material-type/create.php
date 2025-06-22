<?php

use yii\helpers\Html;
use yii\web\View;

/** @var yii\web\View $this */
/* @var $model backend\models\MaterialType */
/** @var array $material_type_list */
/** @var yii\web\UploadedFile $fileModel */

$this->title = Yii::t('app', 'Create Material Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Material Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
document.getElementById("materialtype-icon").addEventListener('change', (event) => {
    if(event.target.value == "") {
        document.getElementById("filemanager-uploadedfile").readonly = false;
    } else {
        document.getElementById("filemanager-uploadedfile").readonly = true;
    }
});
JS;

$this->registerJs($js, View::POS_END);
?>
<div class="material-type-create">
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