<?php

namespace app\models\user;

use dektrium\user\helpers\Password;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\Application as WebApplication;

class User extends \dektrium\user\models\User
{

    public const NOACTIVE = 0;
    public const ACTIVE = 1;
    public const EXPIRE = 3;
    public const DELETED = 4;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            'create' => ['vpnlogin','vpnpassword','status','until','datecreate'],
        ]);
    }

    public function rules()
    {
        $rules = parent::rules();
        // add some rules
        $rules['fieldLength']   = [['vpnlogin','status','vpnpassword'], 'string', 'max' => 255];

        return $rules;
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            if (\Yii::$app instanceof WebApplication) {
                $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Password::hash($this->password));
        }

        return parent::beforeSave($insert);
    }

}
