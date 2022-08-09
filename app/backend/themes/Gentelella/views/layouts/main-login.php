<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use backend\themes\Gentelella\assets\Asset;
use backend\themes\Gentelella\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

$bundle = Asset::register($this);

?>
<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta http-equiv="Content-Type"
        content="text/html; charset=<?= Yii::$app->charset ?>">

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
</head>

<body class="login">
    <?php $this->beginBody() ?>
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <?= $content ?>
                </section>
            </div>

        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
