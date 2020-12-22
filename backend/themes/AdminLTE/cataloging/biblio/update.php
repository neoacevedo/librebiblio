<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Biblio $model */
/** @var array|common\models\MaterialType $materialType */
/** @var array|backend\models\Collection $collection */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Biblio',
        ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="biblio-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box">
        <div class="box-body">
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
