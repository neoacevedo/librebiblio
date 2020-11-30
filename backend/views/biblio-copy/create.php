<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */

$this->title = Yii::t('app', 'Create Biblio Copy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biblio', 'Biblio Copies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-copy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
