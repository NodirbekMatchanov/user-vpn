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

use app\models\Accs;
use app\models\VpnUserSettings;
use app\modules\api\v1\models\Users;
use dektrium\user\models\User;
use dektrium\user\traits\ModuleTrait;
use Yii;
use yii\base\Model;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationForm extends Model
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
    public $promocode;

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
            'usernameLength'   => [['username','phone','promocode'], 'string', 'min' => 3, 'max' => 255],

            // email rules
            'emailTrim'     => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern'  => ['email', 'email'],
            'emailUnique'   => [
                'email',
                'unique',
                'targetClass' => $user,
                'message' => Yii::t('user', 'This email address has already been taken')
            ],
            // password rules
            'passwordRequired' => ['password', 'required', 'skipOnEmpty' => $this->module->enableGeneratingPassword],
            'passwordLength'   => ['password', 'string', 'min' => 6, 'max' => 72],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'    => Yii::t('user', 'Email'),
            'username' => Yii::t('user', 'Username'),
            'password' => Yii::t('user', 'Password'),
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
    public function register()
    {
        $this->username = $this->email;

        if (!$this->validate()) {
            return false;
        }
        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);


        if (!$user->register()) {
            return false;
        }
        $vpnModel = new VpnUserSettings();
        $vpnModel->username = Yii::$app->security->generateRandomString(16);
        $vpnModel->value = Users::RandomToken();
        $vpnModel->email = $this->email;
        $vpnModel->pass = $this->password;
        $vpnModel->promocode = $this->promocode;
        $vpnModel->status = 'ACTIVE';
        $vpnModel->untildate = date('Y-m-d');
        $vpnModel->tariff = "Free";
        $vpnModel->role = "user";
        $vpnModel->createAdmin = false;
        if ($vpnModel->save()) {

        }
        $user = User::find()->where(['email' => $this->email])->one();
        $profile = Profile::findOne($user->id);
        $profile->phone = $this->phone;
        $profile->save();

        Yii::$app->session->setFlash(
            'info',
            Yii::t(
                'user',
                'Your account has been created and a message with further instructions has been sent to your email'
            )
        );

        return true;
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
