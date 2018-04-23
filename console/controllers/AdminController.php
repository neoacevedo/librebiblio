<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;
use console\models\PasswordResetRequest;

/**
 * AdminController implements the Request Password Reset for User model.
 * 
 * Console environment.
 */
class AdminController extends Controller {

    /**
     * Genera un restablecimiento de la contraseña.
     * 
     * El restablecimiento de la contraseña es para backend. La forma de ejecución es como la de un comando de Yii:
     * 
     * ```
     * php yii admin/request-password-reset <email>
     * ```
     * 
     * Esto genera una URL de restablecimiento de contraseña y la envía al correo electrónico del usuario.
     * 
     * Si el correo solcitado no coincide o no existe con el de algún usuario administrativo (backend), genera un error.
     * @param string $email
     */
    public function actionRequestPasswordReset(string $email) {
        $model = new PasswordResetRequest;
        $model->email = $email;
        if ($model->validate()) {
            if ($model->sendEmail()) {
                echo $this->ansiFormat("Email sent.\n", Console::BG_GREEN, \yii\helpers\Console::BOLD);
            } else {
                echo $this->ansiFormat("Sorry, we are unable to reset password for the provided email address.\n", Console::BG_RED, Console::BOLD);
            }
        } else {
            echo $this->ansiFormat($model->errors() . "\n", Console::BG_RED, Console::BOLD);
        }
    }

    /**
     * Ejecuta la actualización de la aplicación.
     * 
     * La actualización se hace basada en un token de autorización desde <strong>BitBucket</strong>.
     */
    public function actionUpdate() {
        if ($this->isEnabled('shell_exec')) {
            print_r(\Yii::$app->params);
            $accessToken = \Yii::$app->params['accessToken'];
            $shell_exec = shell_exec("git pull https://x-token-auth:$accessToken@bitbucket.org/nacevedo/openbiblio2.git");
            echo $this->ansiFormat($shell_exec . "\n", Console::BG_GREEN, \yii\helpers\Console::NORMAL);
            echo $this->ansiFormat("copying params.php...");
            if (YII_ENV_PROD) {
                copy(__DIR__ . '/../../environments/prod/common/config/params.php', __DIR__ . '/../../common/config/params.php');
            } else if (YII_ENV_PROD) {
                copy(__DIR__ . '/../../environments/dev/common/config/params-local.php', __DIR__ . '/../../common/config/params-local.php');
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
