<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use frontend\assets\ThemeAsset;
use common\widgets\Alert;

ThemeAsset::register($this);

$library_name = Yii::$app->name;
$library_hours = \common\models\Settings::find()->one()->library_hours;
$library_phone = \common\models\Settings::find()->one()->library_phone;
$bodyClass = (isset($this->context->bodyClass)) ? $this->context->bodyClass : "" . Yii::$app->session['frontend-skin'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.jpg" type="image/jpg" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
</head>

<body class="<?= $bodyClass ?>">
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => "",
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-expand-md navbar-default fixed-top',
                ],
            ]);
$menuItems = [
    ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
    /* ['label' => 'About', 'url' => ['/site/about']], */
    ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
    $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
} else {
    $menuItems[] = ['label' => Yii::t('app', 'Cart'), 'url' => ['/circulation/cart']];
    $menuItems[] = [
        'label' => Yii::$app->user->identity->username,
        'items' => [
            ['label' => Yii::t('app', 'My Profile'), 'url' => ['/member/profile']],
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t('app', 'Logout'),
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
    ]];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
]);
NavBar::end();
?>

        <div class="container">
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col">
                    <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => [
                    'class' => 'breadcrumb'
                ]
            ])
?>
                </div>
            </div>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <div class="row text-center">
                <div class="col-md-4">
                    <?= Yii::t('library', 'Date') . ": " . Yii::$app->formatter->asDate("now", "full") ?>
                </div>
                <div class="col-md-4">
                    <?= Yii::t('library', 'Library Hours') . ": $library_hours" ?>
                </div>
                <div class="col-md-4">
                    <?= Yii::t('library', 'Library Phone') . ": $library_phone" ?>
                </div>
            </div>
            <!-- Copyright -->
            <hr />
            <div class="text-center">
                OpenBiblio. &copy; 2002-2005 Dave Stevens, et al. |
                LibreBiblio. &copy; <?= date('Y') ?>
                <a href="https://www.neoacevedo.co/" target="_blank">
                    N&eacute;stor
                    Acevedo.</a>
                <?= 'v' . Yii::$app->version ?> |
                <a href="http://www.yiiframework.com/" rel="external">
                    <?= \Yii::t('yii', 'Yii Framework') ?>
                </a>
            </div>
            <div class="row">&nbsp;</div>
            <!-- // -->
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php
$this->endPage();
