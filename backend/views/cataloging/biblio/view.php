<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            [
                'attribute' => 'user',
                'value' => $model->user->username,
                'label' => \Yii::t('app', 'User')
            ],
            [
                'attribute' => 'materialType',
                'value' => $model->materialType->description,
                'label' => 'Material'
            ],
            [
                'attribute' => 'collection',
                'value' => $model->collection->description,
                'label' => Yii::t('app', 'Collection')
            ],
            'call_nmbr1',
            'call_nmbr2',
            'call_nmbr3',
            'title:ntext',
            'title_remainder:ntext',
            'responsibility_stmt:ntext',
            'author:ntext',
            [
                'attribute' => 'opac_flg',
                'value' => 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
            ]
        ],
    ])
    ?>
    <div class="row">
        <h4><?= Yii::t('app', 'Additional Bibliographic Information') ?></h4>
        
    </div>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'topic1:ntext',
            'topic2:ntext',
            'topic3:ntext',
            'topic4:ntext',
            'topic5:ntext',
        ]
    ]);
    ?>
    <?php
    $attrs = [];
    foreach ($biblioFields as $biblioField) {
        $usmarc = backend\models\UsmarcSubfield::findOne(["tag" => $biblioField->tag, "subfield_cd" => $biblioField->subfield_cd]);
        $attrs['attribute'][] = 'field_data';
        $attrs['value'][] = $biblioField->field_data;
        $attrs['label'][] = $usmarc->description;
    }
    echo DetailView::widget([
            'model' => $biblioFields,
            'attributes' => [
                $attrs
                /*[
                    'attribute' => 'field_data',
                    'value' => $attrs['value'][0],
                    'label' => $attrs['label'][0]
                ],
                [
                    'attribute' => 'field_data',
                    'value' => "",
                    'label' => ""
                ]*/
            ]
        ]);
    ?>

</div>
