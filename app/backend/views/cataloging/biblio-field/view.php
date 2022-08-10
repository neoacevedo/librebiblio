<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioField */

$this->title = $model->bibid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cataloging', 'Biblio Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-field-view">

    <h1><?= Html::encode($this->title) ?>
    </h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'bibid' => $model->bibid, 'fieldid' => $model->fieldid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'bibid' => $model->bibid, 'fieldid' => $model->fieldid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'bibid',
            'fieldid',
            'tag',
            'ind1_cd',
            'ind2_cd',
            'subfield_cd',
            'field_data:ntext',
        ],
    ]) ?>

</div>