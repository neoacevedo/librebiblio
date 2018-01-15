<?php

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

