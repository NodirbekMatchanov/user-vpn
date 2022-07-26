<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models\user;

use app\controllers\SiteController;
use app\controllers\user\RegistrationController;
use app\models\Accs;
use app\models\RegistrationUsers;
use app\models\UserEvents;
use app\models\VpnUserSettings;
use app\modules\api\v1\models\Users;
use dektrium\user\Finder;
use dektrium\user\models\LoginForm;
use dektrium\user\models\User;
use dektrium\user\traits\ModuleTrait;
use Yii;
use yii\base\Model;
use yii\web\Controller;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationForm extends \dektrium\user\models\RegistrationForm
{
    use ModuleTrait;

    /**
     * @var string User email address
     */
    public $email;

    /**
     * @var string Username
     */
    public $username;

    public $phone;
    public $password_repeat;
    public $promocode;
    public $utm_source;
    public $utm_medium;
    public $utm_campaign;
    public $utm_term;

    /**
     * @var string Password
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $user = $this->module->modelMap['User'];

        return [
            // username rules
            'usernameLength' => [['username', 'utm_source', 'utm_term', 'utm_campaign', 'utm_medium', 'phone', 'promocode'], 'string', 'min' => 3, 'max' => 255],
            'password_repeat' => ['password_repeat', 'compare','compareAttribute' => 'password'],
            // email rules
            'emailValidate' => ['email', function ($attribute) {
                $error = Yii::t('user', 'This email address has already been taken');
                $user = Accs::find()->where(['email' => $this->email])->one();
                if (!empty($user->email) && $user->email == $this->email) {

                    if ($user->status == VpnUserSettings::$statuses['DELETED']) {
                    } else {
                        $this->addError($attribute, $error);
                        return false;
                    }
                }
                return true;
            }
            ],
            'email' => ['email', 'trim'],
            'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
//            'emailUnique'   => [
//                'email',
//                'unique',
//                'targetClass' => $user,
//                'message' => Yii::t('user', 'This email address has already been taken')
//            ],
            // password rules
            'passwordRequired' => ['password', 'required', 'skipOnEmpty' => $this->module->enableGeneratingPassword],
            'passwordLength' => ['password', 'string', 'min' => 6, 'max' => 72],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user', 'Email'),
            'username' => Yii::t('user', 'Username'),
            'password' => Yii::t('user', 'Password'),
            'password_repeat' => 'Павторный пароль',
            'phone' => Yii::t('user', 'Телефон'),
            'promocode' => Yii::t('user', 'Промокод'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'register-form';
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     *
     * @return bool
     */
    public function temporaryRegister() {
//        if (!$this->validate()) {
//            return false;
//        }
        $regUser = new RegistrationUsers();
        $regUser->email = $this->email;
        $regUser->password = $this->password;
        $regUser->promocode = $this->promocode;
        $regUser->phone = $this->phone;
        $regUser->verifyCode = (string)$this->getVeriFyCode();

        return $regUser->save(false);
    }

    public function register()
    {
        $this->username = $this->email;
        $usedPromocode = false;
        if (!$this->validate()) {
            return false;
        }
        $this->checkUser();
        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);

        $code = $this->getVeriFyCode();
        $_SESSION['code'] = $code;

        if (!$user->register()) {
            return false;
        }
        $vpnModel = new VpnUserSettings();
        $vpnModel->username = Yii::$app->security->generateRandomString(16);
        $vpnModel->value = Users::RandomToken();
        $vpnModel->email = $this->email;
        $vpnModel->pass = $this->password;
        $vpnModel->utm_campaign = $this->utm_campaign;
        $vpnModel->utm_term = $this->utm_term;
        $vpnModel->utm_source = $this->utm_source;
        $vpnModel->utm_medium = $this->utm_medium;
        $vpnModel->used_promocode = $this->promocode;
        $vpnModel->status = \app\models\VpnUserSettings::$statuses['NOACTIVE'];
        $vpnModel->untildate = date('Y-m-d');
        $vpnModel->tariff = "Free";
        $vpnModel->role = "user";
        $vpnModel->createAdmin = false;
        if ($vpnModel->save()) {
            /* +1 promocode */
            $usedPromocode = Accs::setPromoShareCount($this->promocode,$user);
        }
        $user = User::find()->where(['email' => $this->email])->one();
        $profile = Profile::findOne($user->id);
        $profile->phone = $this->phone;
        $profile->save();

        $accs = Accs::find()->where(['user_id' => $user->id])->one();
        if (!empty($accs)) {
            if ($usedPromocode) {
                $accs->untildate = $accs->untildate + (3600 * 24 * 1);
                /* add event */
                $event = new UserEvents();
                $event->event = "6";
                $event->user_id = $user->id;
                $event->text = 'регистрация по промо-коду : '. $this->promocode;
                $event->save();
            }
            $accs->verifyCode = $code;
            $accs->source = Accs::SOURCE_WEB;
            $accs->save(false);
        }

        Yii::$app->session->setFlash(
            'info',
            'Спасибо за регистрацию. Чтобы активировать эккаунт, пожалуйста введите код активации который мы направили вам на почту или перейдите по ссылке в письме.'
        );

        return true;
    }

    public function checkUser() {
        $user = Accs::find()->where(['email' => $this->email])->one();
        if (!empty($user->email) && $user->email == $this->email) {
            if ($user->status == VpnUserSettings::$statuses['DELETED']) {
                $user->status = VpnUserSettings::$statuses['ACTIVE'];
                $user->save();

                $userModel = \app\models\user\User::find()->where(['email' => $this->email])->one();
                $userModel->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                $userModel->save();

                $model = \Yii::createObject(LoginForm::className());

                $model->load(['password' => $this->password, 'login' => $this->email],'');
                $model->login();
                Yii::$app->getResponse()->redirect(["/user/settings/account"]);
            }
        }
    }

    public function getVeriFyCode()
    {
        return rand(111111, 999999);
    }

    /**
     * Loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide.
     *
     * By default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model.
     *
     * @param User $user
     */
    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes);
    }
}
