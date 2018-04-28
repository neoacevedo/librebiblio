<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */

$this->title = Yii::t('app', 'Create Biblio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box">
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'modelBiblioFields' => $modelBiblioFields,
                'usmarc' => $usmarc
            ])
            ?>
        </div>
    </div>
</div>
