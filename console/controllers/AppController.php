<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;

/**
 * ApplicationController implementa la actualización de la aplicación.
 *
 * @author Néstor Acevedo
 */
class AppController extends Controller {

    /**
     * Ejecuta la actualización de la aplicación.
     * 
     * La actualización se hace como un comando de Yii:
     * 
     * ```
     * php yii app/update
     * ```
     * 
     * Si se ha implementado o modificado parte del código fuente las actualizaciones pueden sobreescribir esos cambios.
     * <br />
     * Para ello, se puede modificar la lógica de este método para implementar la actualización desde recursos propios.
     */
    public function actionUpdate() {
        if ($this->isEnabled('shell_exec')) {
            print_r(\Yii::$app->params);
            $accessToken = \Yii::$app->params['accessToken'];
            $shell_exec = shell_exec("git pull https://x-token-auth:$accessToken@bitbucket.org/nacevedo/openbiblio2.git");
            echo $this->ansiFormat($shell_exec . "\n", Console::BG_GREEN, \yii\helpers\Console::NORMAL);
            echo $this->ansiFormat("copying params.php...\n");
            if (YII_ENV_PROD) {
                if (!copy(__DIR__ . '/../../environments/prod/common/config/params.php', __DIR__ . '/../../common/config/params.php')) {
                    echo $this->ansiFormat("Cannot copy params.php. This does not affect your current environment.\n");
                }
            } else if (YII_ENV_DEV) {
                if (!copy(__DIR__ . '/../../environments/dev/common/config/params-local.php', __DIR__ . '/../../common/config/params-local.php')) {
                    echo $this->ansiFormat("Cannot copy params-local.php. This does not affect your current environment.\n");
                }
            }
        } else {
            echo $this->ansiFormat("shell_exec is currently dissabled.\n", Console::BG_RED, Console::BOLD);
        }
    }

    /**
     * Verifica si una función PHP está habilitada.
     * 
     * @access private
     * @param string $func
     * @return bool
     */
    private function isEnabled(string $func) {
        return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
    }

}
