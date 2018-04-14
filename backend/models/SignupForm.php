<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace backend\models;

use yii\base\Model;
use backend\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $address;
    public $password;
    public $status;

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
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'min' => 4, 'max' => 32],
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Member', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 4, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Member', 'message' => 'This email address has already been taken.'],
            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'min' => 4, 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['status', 'required']
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

        $user = new User();
        $user->username = $this->username;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->address = $this->address;
        $user->setPassword($this->password);
        $user->status = $this->status;
        $user->generateAuthKey();
        //
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
    public function generateUniqueRandomString(int $length = 32) {
        $randomString = \Yii::$app->getSecurity()->generateRandomString($length);
        return $randomString;
    }

}
