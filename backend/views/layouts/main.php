<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use pceuropa\menu\Menu;

AppAsset::register($this);
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
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => 'OpenBiblio2',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            } else {
                $items = [];
                foreach (Menu::NavbarRight(2) as $menu) {
                    $item['label'] = Yii::t('app', $menu['label']);
                    $item['url'] = $menu['url'];
                    $item['type'] = $menu['type'];
                    array_push($menuItems, $item);
                }

                // este menú cambia para el administrador.
                $roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                $isAdmin = false;
                foreach ($roles as $role) {
                    if ($role->name == "admin") {
                        $isAdmin = true;
                    }
                }
                if ($isAdmin) {
                    $menuItems[] = ['label' => Yii::$app->user->identity->username,
                        'items' => [
                            ['label' => Yii::t('app', 'Settings'), 'url' => "#", 'class' => 'btn btn-link'],
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                    Yii::t('app', 'Logout'), ['class' => 'btn btn-link']
                            )
                            . Html::endForm()
                            . '</li>'
                        ]];
                } else {
                    $menuItems[] = '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                    Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>';
                }
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
                <p class="pull-left">&copy; OpenBiblio2 <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
