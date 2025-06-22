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
use console\models\PasswordResetRequest;
use DateTime;

/**
 * AdminController implementa el restablecimiento de contraseñas para el modelo User.<br />
 * Implementa también la eliminación de reservas bibliográficas.
 *
 * Console environment.
 */
class AdminController extends Controller
{
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
    public function actionRequestPasswordReset(string $email)
    {
        $model = new PasswordResetRequest();
        $model->email = $email;
        if ($model->validate()) {
            if ($model->sendEmail()) {
                echo $this->ansiFormat("Correo enviado al usuario.\n", Console::BG_GREEN, \yii\helpers\Console::BOLD);
            } else {
                echo $this->ansiFormat("Lo sentimos, no podemos restablecer la contraseña para la dirección de correo electrónico proporcionada.\n", Console::BG_RED, Console::BOLD);
            }
        } else {
            foreach ($model->errors as $key => $error) {
                echo $this->ansiFormat($error[0] . "\n", Console::FG_RED, Console::BOLD);
            }
        }
    }

    /**
     * Verifica si hay copias bibliográficas reservadas y cambia su estado si estas exceden el tiempo límite.
     *
     * La ejecución se hace como un comando de Yii:
     *
     * ```
     * php yii admin/remove-placeholds
     * ```
     *
     * Busca cada copia y verifica si el número de días en reserva ha superado el establecido y procede a
     * eliminar las reservas que coincidan con ese límite.
     */
    public function actionRemovePlaceholds()
    {
        $holds = \common\models\BiblioHold::find()->all();
        $holdMaxDays = \common\models\Settings::find()->one()->hold_max_days;
        if (count($holds) === 0) {
            echo $this->ansiFormat("No hay copias reservadas.\n");
        }
        foreach ($holds as $hold) {
            $copy = \common\models\BiblioCopy::findOne($hold->copyid);
            $datetime1 = new DateTime($hold->hold_begin_dt);
            $datetime2 = new DateTime('now');
            $interval = $datetime1->diff($datetime2);
            $diff = (int) $interval->format('%r%a');
            if ($holdMaxDays > 0 && $diff > $holdMaxDays) {
                $hold->delete();
                if ($copy->status_cd === 'hld') {
                    $copy->status_cd = 'in';
                    $copy->status_begin_dt = date('Y-m-d H:i:s');
                    $copy->save();
                }
                echo $this->ansiFormat("Copia {$copy->barcode_nmbr} disponible para préstamo.\n");
            } else {
                echo $this->ansiFormat("Las reservas aún no alcanzan el tiempo de expiración.\n");
            }
        }
    }
}
