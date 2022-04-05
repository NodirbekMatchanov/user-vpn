<?php

namespace app\models\user;

use app\models\Accs;
use dektrium\user\helpers\Password;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\Application as WebApplication;
use Yii;

class User extends \dektrium\user\models\User
{

    public const NOACTIVE = 0;
    public const ACTIVE = 1;
    public const EXPIRE = 3;
    public const DELETED = 4;

    public function rules()
    {
        return array_merge(parent::rules(),
            [
                [['name', 'email'], 'required'],
                [['phone', 'phone', 'access_user'], 'string'],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
            [
                'name' => 'Имя',
                'phone' => 'Телефон',
            ]
        );
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

    public static function checkAccess()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->getId();
            if (!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])) {
                return true;
            }
        }
        return false;
//        $accs = Accs::find()->where(['user_id' => $userId])->one();
//        if(empty($accs) && $accs->role){
//
//        }
    }

    public function isAdmin()
    {
        $userId = Yii::$app->user->identity->getId();
        if (!empty(Yii::$app->authManager->getRolesByUser($userId)['admin'])) {
            return true;
        }
        return false;
    }
    public function getEmail()
    {
      return $this->email;
    }

}
