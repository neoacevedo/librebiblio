<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\AppAsset::register($this);
}

#CrudAsset::register($this);

backend\assets\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$library_name = Yii::$app->name; //null !== $settings->library_name ? $settings->library_name : "OpenBiblio2";
$library_hours = \common\models\Settings::find()->one()->library_hours; //null !== $settings->library_hours ? $settings->library_hours : "N/A";
$library_phone = \common\models\Settings::find()->one()->library_phone; //null !== $settings->library_phone ? $settings->library_phone : "N/A";
$bodyClass = (isset($this->context->bodyClass)) ? $this->context->bodyClass : 'hold-transition sidebar-mini skin-'.Yii::$app->session['backend-skin'];
$roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
$isAdmin = false;
foreach ($roles as $role) {
    if ($role->name == 'admin') {
        $isAdmin = true;
    }
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">

            <?=
            $this->render(
                    'header',
                    ['directoryAsset' => $directoryAsset, 'isAdmin' => $isAdmin]
            )
            ?>

            <?=
            $this->render(
                    'left',
                    ['directoryAsset' => $directoryAsset]
            )
            ?>

            <?=
            $this->render(
                    'content',
                    ['content' => $content, 'directoryAsset' => $directoryAsset]
            )
            ?>

        </div>

        <?php $this->endBody() ?>
        <script>
            /*$(".alert").fadeTo(3000, 500).slideUp(1000, function () {
                $(".alert").alert('close');
            });*/
        </script>
    </body>
</html>
<?php $this->endPage() ?>
