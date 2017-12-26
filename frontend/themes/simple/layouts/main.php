<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$settings = \common\models\Settings::find()->one();
$library_name = null !== $settings->library_name ? $settings->library_name : "OpenBiblio2";
$library_hours = null !== $settings->library_hours ? $settings->library_hours : "N/A";
$library_phone = null !== $settings->library_hours ? $settings->library_phone : "N/A";
$brandLabel = "";
if ($settings->library_image_url !== null) {
    $brandLabel .= Html::img('@web/images/logo/' . $settings->library_image_url, ['alt' => $library_name, 'class' => 'img-responsive', 'style' => 'width: 33px; padding: 0 0; display: inline-block']);
}

if ($settings->use_image_flg == 0) {
    $brandLabel .= "&nbsp;$library_name";
}

$bodyClass = (isset($this->context->bodyClass)) ? $this->context->bodyClass : "".Yii::$app->session['backend-skin'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="<?= $bodyClass ?>">
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => $brandLabel,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => Yii::t('app', 'My Account'), 'url' => ['/member/account']],
                        ['label' => Yii::t('app', 'History'), 'url' => ['/member/history']],
                        '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                                Yii::t('app', 'Logout'), ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
                ]];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="col-md-4"><?= Yii::t('library', 'Date') . ": " . Yii::$app->formatter->asDate("now", "full") ?></div>
                    <div class="col-md-4"><?= Yii::t('library', 'Library Hours') . ": $library_hours" ?></div>
                    <div class="col-md-4"><?= Yii::t('library', 'Library Phone') . ": $library_phone" ?></div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="col-lg-4 col-md-4 col-sm-4">OpenBiblio. &copy; 2002-2005 Dave Stevens, et al.</div>
                    <div class="col-lg-4 col-md-4 col-sm-4">OpenBiblio2, <?= date('Y') ?></div>
                    <div class="col-lg-4 col-md-4 col-sm-4"><?= Yii::powered() ?></div>
                </div>
                <p>&nbsp;</p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
