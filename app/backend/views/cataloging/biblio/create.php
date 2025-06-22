<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Biblio $model */
/** @var array|common\models\MaterialType $materialType */
/** @var array|backend\models\Collection $collection */
/** @var neoacevedo\yii2\storage\models\FileManager $fileModel */
/** @var \common\models\BiblioField[] $modelBiblioFields */

$this->title = Yii::t('app', 'Create Biblio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="biblio-create">
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