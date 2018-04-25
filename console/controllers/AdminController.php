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
                echo $this->ansiFormat("Coreo enviado al usuario.\n", Console::BG_GREEN, \yii\helpers\Console::BOLD);
            } else {
                echo $this->ansiFormat("Lo sentimos, no podemos restablecer la contraseña para la dirección de correo electrónico proporcionada.\n", Console::BG_RED, Console::BOLD);
            }
        } else {
            echo $this->ansiFormat($model->errors() . "\n", Console::BG_RED, Console::BOLD);
        }
    }

    /**
     * Verifica si hay copias bibliográficas reservadas y cambia su estado si estas exceden el tiempo límite.
     * 
     * La ejecución se hace como un comando de Yii:
     * 
     * ```
     * php yii app/remove-placeholds
     * ```
     * 
     * Busca cada copia y verifica si el número de días en reserva ha superado el establecido y procede a 
     * eliminar las reservas que coincidan con ese límite.
     */
    public function actionRemovePlaceholds() {
        $copies = \common\models\BiblioCopy::findAll(['status_cd' => 'hld']);
        $holdMaxDays = \common\models\Settings::find()->one()->hold_max_days;
        foreach ($copies as $copy) {
            $hold = \common\models\BiblioHold::findOne(['copyid' => $copy->id]);
            $datetime1 = new DateTime($hold->created_at);
            $datetime2 = new DateTime('now');
            $interval = $datetime1->diff($datetime2);
            $diff = (int) $interval->format('%r%a');
            if ($holdMaxDays > 0 && $diff > $holdMaxDays) {
                $tooOld = true;
            } else {
                $tooOld = false;
            }

            if ($tooOld) {
                $hold->delete();
                $copy->status_cd = 'in';
                $copy->status_begin_dt = date('Y-m-d H:i:s');
                $copy->save();
                $this->ansiFormat("Copia {$copy->barcode_nmbr} disponible para préstamo.\n");
            }
        }
    }

}
