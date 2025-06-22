<?php

/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
