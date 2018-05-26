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
 * AppController implementa la actualización de la aplicación.
 *
 * @author Néstor Acevedo
 */
class AppController extends Controller 
{

    /**
     * Ejecuta la actualización de la aplicación.
     * 
     * La actualización se hace como un comando de Yii:
     * 
     * ```
     * php yii app/update <token>
     * ```
     * 
     * Si se ha implementado o modificado parte del código fuente, las actualizaciones sobreescribirán esos cambios.
     * <br />
     * Para ello, se puede modificar la lógica de este método para implementar la actualización desde recursos propios 
     * (Repositorios privados, archivos comprimidos en almacenamiento privado, etc).
     * @param string $token Token de autorización.
     */
    public function actionUpdate(string $token) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://bitbucket.org/site/oauth2/access_token");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "client_id" => \Yii::$app->params['updateKey'],
            "client_secret" => \Yii::$app->params['updateSecret'],
            "grant_type" => "refresh_token",
            "refresh_token" => $token]);

        $response = curl_exec($ch);
        curl_close($ch);
        
        $auth = \json_decode($response);
        
        $cmd = "git init && "
                . "git remote add origin https://x-token-auth:{$auth->access_token}@bitbucket.org/nacevedo/openbiblio2.git "
                . "&& git fetch --all && git reset --hard origin/master";

        echo $this->ansiFormat("Antes de continuar, verifique que haya hecho un respaldo del sitio web "
                . "(archivos y base de datos).\n"
                . "Este procedimiento reemplazará cualquier cambio hecho en el código fuente.\n"
                . "Proceda luego con la actualización y ejecute una nueva migración de BD.\n\n", Console::BG_GREEN, Console::BOLD);
        
        if ($this->confirm("¿Desea continuar / Do you want to proceed?")) {
            if ($this->isEnabled('shell_exec')) {
                $shell_exec = \shell_exec($cmd);
                echo $this->ansiFormat($shell_exec . "\n", Console::BG_GREEN, \yii\helpers\Console::NORMAL);
                echo $this->ansiFormat("copiando params.php...\n");
                if (YII_ENV_PROD) {
                    if (!\copy(__DIR__ . '/../../environments/prod/common/config/params.php', __DIR__ . '/../../common/config/params.php')) {
                        echo $this->ansiFormat("No se puede copiar common/config/params.php. Esto no afecta su entorno actual.\n");
                    }

                    if (!\copy(__DIR__ . '/../../environments/prod/console/config/params.php', __DIR__ . '/../../console/config/params.php')) {
                        echo $this->ansiFormat("No se puede copiar console/config/params.php. Esto no afecta su entorno actual.\n");
                    }
                } elseif (YII_ENV_DEV) {
                    if (!\copy(__DIR__ . '/../../environments/dev/common/config/params-local.php', __DIR__ . '/../../common/config/params-local.php')) {
                        echo $this->ansiFormat("No se puede copiar common/config/params-local.php. Esto no afecta su entorno actual.\n");
                    }

                    if (!\copy(__DIR__ . '/../../environments/dev/console/config/params-local.php', __DIR__ . '/../../console/config/params-local.php')) {
                        echo $this->ansiFormat("No se puede copiar console/config/params-local.php. Esto no afecta su entorno actual.\n");
                    }
                }
                \shell_exec("rm -rf " . __DIR__ . '/../../.git');
            } else {
                echo $this->ansiFormat("shell_exec no está habilitado. "
                        . "Por favor solicite una actualización por medio de un correo electrónico.\n", Console::BG_RED, Console::BOLD);
            }
        }
    }

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
