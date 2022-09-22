<?php

namespace app\models;

use Exception;
use Symfony\Component\VarDumper\VarDumper as VarDumperVarDumper;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;
use app\models\helpers;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        try {
            return [
                [['username', 'password', 'password_repeat'], 'required'],
                [['username', 'password', 'password_repeat'], 'string', 'min' => 4, 'max' => 16],
                ['password_repeat', 'compare', 'compareAttribute' => 'password']

            ];
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }


    /**
     * Signup a user using the provided username and password.
     * @return bool whether the user is signup successfully
     */
    public function signup()
    {
        try {
            $user = new User();
            $user->username = $this->username;
            $user->password = \Yii::$app->security->generatePasswordHash($this->password);
            $user->acess_token = \yii::$app->security->generateRandomKey();
            $user->auth_key = \yii::$app->security->generateRandomKey();
            $user->role = "user";

            if ($user->save()) {
                return true;
            }

            \yii::error(message: "User was not saved" . VarDumper::dumpAsString($user->errors));

            return false;
        } catch (Exception $e) {
            $helper = new helpers();
            $helper->log_error($e);
            return false;
        }
    }
}
