<?php

namespace common\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $first_name;
    public $last_name;
    public $pin;
    public $phone;
    public $address;
    public $email;
    public $password;
    public $classification_id;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['first_name', 'trim'],
            ['first_name', 'required'],
            ['first_name', 'string', 'min' => 4, 'max' => 255],
            ['last_name', 'trim'],
            ['last_name', 'required'],
            ['last_name', 'string', 'min' => 4, 'max' => 255],
            ['pin', 'required'],
            ['pin', 'number', 'min' => 1],
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'min' => 4, 'max' => 32],
            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'min' => 5, 'max' => 255],
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Member', 'message' => \Yii::t('app', 'This username has already been taken.')],
            ['username', 'string', 'min' => 4, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Member', 'message' => \Yii::t('app', 'This email address has already been taken.')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new Member();
        $user->username = $this->username;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->pin = $this->pin;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->address = $this->address;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = 10;
        $user->classification_id = $this->classification_id ?: 1;

        if ($user->save()) {
            return $user;
        } else {
            @array_walk_recursive($user->errors, function($v, $k) {
                        \Yii::$app->getSession()->setFlash('error', $v);
                    });
            return null;
        }
    }

    /**
     * Genera un texto aleatorio de una longitud específica
     * @param int $length
     * @return string
     */
    public function generateUniqueRandomString($length = 32) {
        $randomString = \Yii::$app->getSecurity()->generateRandomString($length);
        return $randomString;
    }
    
    
    public function sendEmail(int $id) {
        $user = Member::findOne($id);

        if (!Member::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return \Yii::$app->mailer
                        ->compose(
                                ['html' => 'userSignup-html', 'text' => 'userSignup-text'], ['user' => $user]
                        )
                        ->setTo($user->email)
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setSubject('Signup Confirmation')
                        ->send();
    }

}
