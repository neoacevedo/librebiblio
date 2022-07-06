<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        El error anterior ocurri&oacute; mientras el Servidor Web estaba procesando su petici&oacute;
    </p>
    <p>
        Por favor cont&aacute;ctenos si cree que este es un error del servidor. Gracias.
    </p>

</div>
