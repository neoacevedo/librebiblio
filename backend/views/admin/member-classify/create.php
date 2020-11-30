<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MemberClassify */

$this->title = Yii::t('app', 'Create Member Classify');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Member Classifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-classify-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
