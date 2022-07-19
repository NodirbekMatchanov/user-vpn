<?php

namespace app\models\user;

use app\models\Accs;
use app\models\Promocodes;
use app\models\Settings;
use app\models\UsedPromocodes;
use dektrium\user\helpers\Password;
use dektrium\user\models\Token;
use yii\base\NotSupportedException;
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
    public $name;


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

    public static function getUserList()
    {
        $accs = Accs::find()->where(['role' => 'user'])->all();
        if (empty($accs)) {
            return [];
        }
        $ids = [];
        foreach ($accs as $acc) {
            $ids[] = $acc['user_id'];
        }
        $users = User::find()->where(['IN', 'id', $ids])->all();
        return !empty($users) ? ArrayHelper::map($users, 'id', 'email') : [];
    }

    public function getStatus()
    {
        $userId = Yii::$app->user->identity->getId();
        $accs = Accs::find()->where(['user_id' => $userId])->one();
        return $accs->status ?? 0;
    }

    public function getSettings()
    {
        $settings = Settings::find()->asArray()->all();
        if (empty($settings)) {
            return [];
        }
        $settingMap = [];
        foreach ($settings as $setting) {
            $settingMap[$setting['name']] = $setting['value'];
        }
        return $settingMap;
    }

    public function getPromoCodes()
    {
        $usedCodes = UsedPromocodes::find()->andwhere(['used_promocodes.user_id' => Yii::$app->user->identity->getId()])->andWhere(['!=','used_promocodes.status',2])
            ->joinWith('code')->asArray()->one();
        return $usedCodes;
    }

    /**
     * Attempts user confirmation.
     *
     * @param string $code Confirmation code.
     *
     * @return boolean
     */
    public function attemptConfirmation($code)
    {
        $token = $this->finder->findTokenByParams($this->id, $code, Token::TYPE_CONFIRMATION);
        if (1) {
            if (($success = $this->confirm())) {
                \Yii::$app->user->login($this, $this->module->rememberFor);
                $message = \Yii::t('user', 'Thank you, registration is now complete.');
            } else {
                $message = \Yii::t('user', 'Something went wrong and your account has not been confirmed.');
            }
        } else {
            $success = false;
            $message = \Yii::t('user', 'The confirmation link is invalid or expired. Please try requesting a new one.');
        }

        \Yii::$app->session->setFlash($success ? 'success' : 'danger', $message);

        return $success;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
}
