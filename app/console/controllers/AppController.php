<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;

/**
 * AppController implementa diversos comandos de la aplicación.
 *
 * @author Néstor Acevedo
 */
class AppController extends Controller
{
    /**
     * Verifica si una función PHP está habilitada.
     *
     * @access private
     * @param string $func
     * @return bool
     */
    private function isEnabled(string $func)
    {
        return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
    }
}
