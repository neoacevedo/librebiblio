<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Member model
 *
 * @property integer $id
 * @property string $username
 * @propoerty string $first_name
 * @propoerty string $last_name
 * @property double $pin
 * @property string phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $address
 * @property string $auth_key
 * @property integer $status
 * @property integer $classification_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Member extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_BLOCKED = 5;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

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
            ['pin', 'number'],
            ['pin', 'required'],
            ['pin', 'unique', 'targetClass' => '\common\models\Member', 'message' => Yii::t('member', 'This PIN number has already registered.')],
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'min' => 4, 'max' => 32],
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Member', 'message' => Yii::t('member', 'This username has already been taken.')],
            ['username', 'string', 'min' => 4, 'max' => 255],
            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'min' => 5, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Member', 'message' => Yii::t('member', 'This email address has already been taken.')],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BLOCKED, self::STATUS_DELETED]],
            ['status', 'integer', 'message' => Yii::t('app', 'This is not a valid status.')],
            ['classification_id', 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'pin' => Yii::t('member', 'Pin'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status')
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        //return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return static::findOne(['id' => $id, 'status' => [self::STATUS_ACTIVE, self::STATUS_BLOCKED]]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username) {
        //return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        return static::findOne(['username' => $username, 'status' => [self::STATUS_ACTIVE, self::STATUS_BLOCKED]]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => [self::STATUS_ACTIVE, self::STATUS_BLOCKED]
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

// attributos

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }
    
    /**
     * @inheritdoc
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword(string $password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    // filter out some fields, best used when you want to inherit the parent implementation
// and blacklist some sensitive fields.
    public function fields() {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['password'], $fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

        return $fields;
    }

}
