<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Host del servidor de cache
 */
define("CACHE_HOST", "%%CACHE_HOST%%");

/**
 * Puerto del servidor de cache
 */
define('CACHE_PORT', '%%CACHE_PORT%%');

/**
 * Gestión de caché.
 * 
 * Esta configuración verifica si la extensión <strong>MemCached</strong> está cargado o no.
 */
if (extension_loaded('memcached')) {
    $cache['class'] = "yii\caching\MemCache";
    $servers['host'] = CACHE_HOST;
    $servers['port'] = CACHE_PORT;
    $servers['weight'] = 100;
    $cache['servers'] = [];
    array_push($cache['servers'], $servers);
    $cache['useMemcached'] = true;
} else {
    $cache['class'] = 'yii\caching\FileCache';
}

return $cache;
