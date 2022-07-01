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
                echo "<h1>" . Html::img('@web/images/logo/' . $settings->library_image_url, ['alt' => $this->title, 'class' => 'img-responsive', 'style' => 'width: 96px; padding: 0 0; display: inline-block']);
                echo "$this->title</h1>";
            } else {
                echo Html::img('@web/images/logo/' . $settings->library_image_url, ['alt' => $this->title, 'class' => 'img-responsive', 'style' => 'display: inline-block']);
            }
        }
        ?>
        <?php
        $form = ActiveForm::begin([
                    'action' => ['search'],
                    'method' => 'get',
                    'options' => ['class' => 'form-inline', 'id' => 'search']
        ]);
        ?>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-2 col-md-2 col-sm-2">&nbsp;</div>
                <div class="col-lg-8 col-md-8 col-sm-8">

                    <input id="input_search" name="BiblioSearch[title]" class="form-control input-lg"
                        style="width: 83.33333333%" />
                    <input type="hidden" name="BiblioSearch[opac_flg]" value="1" />
                    <!--<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-search"></i></button>-->

                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">&nbsp;</div>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-xs-4">&nbsp;</div>
            <div class="col-xs-4">
                <button type="button" name="search_opt" title="" value="BiblioSearch[title]"
                    class="btn btn-sm btn-default biblio"> <?= Yii::t('app', 'Title') ?></button>
                <button type="button" name="search_opt" value="BiblioSearch[author]"
                    class="btn btn-sm btn-default biblio"> <?= Yii::t('app', 'Author') ?></button>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
        <?php
        ActiveForm::end();
        ?>
    </div>
</div>