<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Gestión de caché.
 * 
 * Esta configuración verifica si la extensión <strong>MemCached</strong> está cargado o no.
 */
if (extension_loaded('memcached')) {
    $cache['class'] = "yii\caching\MemCache";
    $servers['host'] = filter_input(INPUT_SERVER | INPUT_ENV, "CACHE_HOST");
    $servers['port'] = filter_input(INPUT_SERVER | INPUT_ENV, "CACHE_PORT");
    $servers['weight'] = 100;
    $cache['servers'] = [];
    array_push($cache['servers'], $servers);
    $cache['useMemcached'] = true;
} else {
    $cache['class'] = 'yii\caching\FileCache';
}

return $cache;

