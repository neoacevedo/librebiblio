<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Biblio $model */
/** @var array|common\models\MaterialType $materialType */
/** @var array|backend\models\Collection $collection */
/** @var \common\models\BiblioField[] $modelBiblioFields */
/** @var neoacevedo\yii2\storage\models\FileManager $fileModel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Biblio',
        ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="biblio-update">
    <div class="card">
        <div class="card-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'modelBiblioFields' => $modelBiblioFields,
                'usmarc' => $usmarc,
                'fileModel' => $fileModel,
                'materialType' => $materialType,
                'collection' => $collection
            ])
            ?>
        </div>
    </div>
</div>