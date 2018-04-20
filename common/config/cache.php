<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Gestión de caché.
 * 
 * Esta configuración verifica si la aplicación está corriendo en Windows o en sistemas basados en UNIX/Linux
 * 
 * Si corre en Windows, se usa exclusivamente caché de archivo ya que Memcached no está disponible para Windows.
 */
if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    $cache['class'] = "yii\caching\MemCache";
    $servers['host'] = 'localhost';
    $servers['port'] = 11211;
    $servers['weight'] = 100;
    $cache['servers'] = [];
    array_push($cache['servers'], $servers);
    $cache['useMemcached'] = true;
} else {
    $cache['class'] = 'yii\caching\FileCache';
}

return $cache;

