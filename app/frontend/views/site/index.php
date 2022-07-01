<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$settings = \common\models\Settings::find()->one();
$this->title = null !== $settings->library_name ? $settings->library_name : "OpenBiblio2";
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= $this->title ?>
        </h1>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-2 col-md-2 col-sm-2"></div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <?php
                    $form = ActiveForm::begin([
                                'action' => ['search'],
                                'method' => 'get',
                                'options' => ['class' => 'form-inline']
                    ]);
                    ?>
                    <input id="input_search" name="BiblioSearch[title]" class="form-control input-lg"
                        style="width: 83.33333333%" />
                    <input type="hidden" name="BiblioSearch[opac_flg]" value="1" />
                    <button type="submit" class="btn btn-sm btn-success"><i
                            class="glyphicon glyphicon-search"></i></button>
                    <?php
                    ActiveForm::end();
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5"></div>
            <div class="col-lg-2 col-md-2 col-sm-2">
                <input type="radio" name="search_opt" value="BiblioSearch[title]" checked="checked"
                    class="form-inline biblio" onchange="changeName(this.value)" /> <?= Yii::t('app', 'Title') ?>
                <input type="radio" name="search_opt" value="BiblioSearch[author]" class="form-inline biblio"
                    onchange="changeName(this.value)" /> <?= Yii::t('app', 'Author') ?>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5"></div>
            <script>
                function changeName(name) {
                    search = document.getElementById('input_search');
                    search.name = name;
                }
            </script>
        </div>
    </div>


    <div class="body-content">
        <!--
        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
-->
    </div>