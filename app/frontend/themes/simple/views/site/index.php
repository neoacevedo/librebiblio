<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$settings = \common\models\Settings::find()->one();
$this->title = null !== $settings->library_name ? $settings->library_name : "LibreBiblio";
$this->registerJs(""
        . "\$('.biblio').click(function() {
                    \$('#input_search').attr('name', \$(this).val());
                    \$('#search').submit();
                });");
?>
<div class="site-index">
    <div class="jumbotron">

        <?php
        if ($settings->library_image_url === null) {
            echo "<h1>$this->title</h1>";
        } else {
            if ($settings->use_image_flg === 0) {
                echo "<h1>" . Html::img($settings->library_image_url, ['alt' => $this->title, 'class' => 'img-fluid', 'style' => 'width: 96px; padding: 0 0; display: inline-block']);
                echo "$this->title</h1>";
            } else {
                echo Html::img($settings->library_image_url, ['alt' => $this->title, 'class' => 'img-fluid mx-auto', 'style' => 'display: inline-block; width: 240px;']);
            }
        }
?>
        <div class="row">&nbsp;</div>
        <?php
        $form = ActiveForm::begin([
                    'action' => ['search'],
                    'method' => 'get',
                    'options' => ['id' => 'search']
        ]);
?>
        <div class="form-row">
            <div class="col-2">&nbsp;</div>
            <div class="col">
                <input id="input_search" name="BiblioSearch[title]" class="form-control form-control-lg" />
                <input type="hidden" name="BiblioSearch[opac_flg]" value="1" />
            </div>
            <div class="col-2">&nbsp;</div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="form-row">
            <div class="col-2">&nbsp;</div>
            <div class="col">
                <button type="button" name="search_opt" title="" value="BiblioSearch[title]"
                    class="btn btn-sm btn-light biblio"> <?= Yii::t('app', 'Title') ?></button>
                &nbsp;
                <button type="button" name="search_opt" value="BiblioSearch[author]"
                    class="btn btn-sm btn-light biblio">
                    <?= Yii::t('app', 'Author') ?></button>
            </div>
            <div class="col-2">&nbsp;</div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>