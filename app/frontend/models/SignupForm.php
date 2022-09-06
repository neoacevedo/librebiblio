<?php

namespace frontend\models;

use common\models\Member;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name'], 'trim'],
            [['username', 'first_name', 'last_name', 'pin', 'address', 'email', 'phone', 'classification_id'], 'required'],
            [['pin'], 'number'],
            [['classification_id'], 'integer'],
            [['username', 'first_name', 'last_name', 'address', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['pin'], 'unique'],
            [['classification_id'], 'exist', 'skipOnError' => false, 'targetClass' => MemberClassify::class, 'targetAttribute' => ['classification_id' => 'id']],
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
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
        $user->generateEmailVerificationToken();
        $user->status = Member::STATUS_ACTIVE;
        $user->classification_id = $this->classification_id;

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Envía un correo electrónico con la información para crear la contraseña.
     * @param Member $user
     * @return boolean
     */
    public function sendEmail(Member $user)
    {
        if (!Member::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return \Yii::$app->mailer
                        ->compose(
                            ['html' => 'userSignup-html', 'text' => 'userSignup-text'],
                            ['user' => $user]
                        )
                        ->setTo($user->email)
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setSubject('Signup Confirmation')
                        ->send();
    }
}
