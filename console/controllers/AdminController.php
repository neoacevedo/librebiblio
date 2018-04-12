<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use console\models\PasswordResetRequest;

/**
 * AdminController implements the Request Password Reset for User model.
 */
class AdminController extends Controller {

    /**
     * Requests password reset.
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
            echo $this->ansiFormat($model->errors()."\n", Console::BG_RED, Console::BOLD);
        }
    }
}
