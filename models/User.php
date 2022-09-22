<?php

namespace app\models;

use Yii;
use Exception;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $acess_token
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        try {
            return [
                [['username', 'password', 'auth_key', 'acess_token'], 'required'],
                [['username'], 'string', 'max' => 55],
                [['password', 'auth_key', 'acess_token'], 'string', 'max' => 255],
            ];
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {

        try {
            return [
                'id' => 'ID',
                'username' => 'Username',
                'password' => 'Password',
                'auth_key' => 'Auth Key',
                'acess_token' => 'Acess Token',
            ];
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        try {
            return self::findOne($id);
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        try {
            return self::find()->where(["acess_token" => $token])->one();
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        try {
            return self::findOne(["username" => $username]);
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {

        try {
            return $this->id;
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {

        try {
            return $this->auth_key;
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        try {
            return $this->auth_key === $authKey;
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        try {
            return Yii::$app->security->validatePassword($password, $this->password);
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }
}
