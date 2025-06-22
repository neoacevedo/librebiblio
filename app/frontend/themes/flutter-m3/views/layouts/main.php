<?php

/** @var \yii\web\View $this */

use frontend\assets\ThemeAsset;

$assets = ThemeAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <!--
    If you are serving your web app in a path other than the root, change the
    href value below to reflect the base path you are serving from.

    The path provided below has to start and end with a slash "/" in order for
    it to work correctly.

    For more details:
    * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/base

    This is a placeholder for base href that will be replaced by the value of
    the `--base-href` argument provided to `flutter build`.
  -->
    <base href="/">

    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="IE=Edge" http-equiv="X-UA-Compatible">
    <meta name="description" content="A new Flutter Uber-like project.">

    <!-- iOS meta tags & icons -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="taxyii">
    <link rel="apple-touch-icon" href="<?php echo $assets->baseUrl; ?>/icons/Icon-192.png">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $assets->baseUrl; ?>/favicon.png" />

    <title>taxyii</title>
    <link rel="manifest" href="<?php echo $assets->baseUrl; ?>/manifest.json">

    <script>
    // The value below is injected by flutter build, do not touch.
    var serviceWorkerVersion = "1212977759";
    </script>
    <!-- This script adds the flutter initialization JS code -->
    <script src="<?php echo $assets->baseUrl; ?>/flutter.js" defer></script>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <script>
    window.addEventListener('load', function(ev) {
        // Download main.dart.js
        _flutter.loader.loadEntrypoint({
            serviceWorker: {
                serviceWorkerVersion: serviceWorkerVersion,
            },
            entrypointUrl: "<?php echo $assets->baseUrl; ?>/main.dart.js",
            onEntrypointLoaded: function(engineInitializer) {
                engineInitializer.initializeEngine({
                    assetBase: "<?php echo $assets->baseUrl; ?>/",
                }).then(function(appRunner) {
                    appRunner.runApp();
                });
            }
        });
    });
    </script>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();