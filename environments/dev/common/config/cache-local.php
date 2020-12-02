<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
$useMemcached = filter_input(INPUT_SERVER, "USE_MEMCACHED") ?? filter_input(INPUT_ENV, "USE_MEMCACHED");
/**
 * Gestión de caché.
 * 
 * Esta configuración verifica si la extensión <strong>MemCached</strong> está cargado o no.
 */
if (extension_loaded('memcached')) {
    $cache['class'] = "yii\caching\MemCache";
    $servers['host'] = filter_input(INPUT_SERVER, "CACHE_HOST") ?? filter_input(INPUT_ENV, "CACHE_HOST");
    $servers['port'] = filter_input(INPUT_SERVER, "CACHE_PORT") ?? filter_input(INPUT_ENV, "CACHE_PORT");
    $servers['weight'] = 100;
    $cache['servers'] = [];
    array_push($cache['servers'], $servers);
    $cache['useMemcached'] = true;
} else {
    $cache['class'] = 'yii\caching\FileCache';
}

return $cache;

