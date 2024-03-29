<?php

namespace app\modules\api\v1\models;

use app\components\DateFormat;
use app\models\Accs;
use app\models\Mailer;
use app\models\MailHistory;
use app\models\RegistrationUsers;
use app\models\TelegramUsers;
use app\models\UnioneMailer;
use app\models\user\Profile;
use app\models\user\LoginForm;
use app\models\UserEvents;
use http\Message;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\modules\api\v1\models\VpnUserSettings;
use dektrium\user\models\User;

class Registration extends \yii\db\ActiveRecord
{
    public $vpnLogin;
    public $vpnPassword;
    public $phone;
    public $lang;
    public $using_promocode;
    public $language;
    public $version;
    public $source_name;
    public $deviceId;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accs';
    }

    public static function getDb()
    {
        return \Yii::$app->get('db2');
    }

    public function rules()
    {
        return [
            [['email'],'required'],
            [['role', 'pass','chatId', 'lang', 'country','deviceId', 'language', 'version', 'source_name',  'using_promocode', 'promocode', 'source', 'used_promocode', 'fcm_token', 'ios_token', 'phone', 'status', 'email',], 'string', 'max' => 255],
            [['vpnid', 'id', 'promo_share', 'verifyCode', 'user_id'], 'integer'],
//            ['email', 'unique'],
            ['datecreate', 'safe'],
//            ['avtoNumber', 'match', 'pattern' => '/^[а-яА-Я]{1}\s?[0-9]{3}\s?[а-яА-Я]{2}\s?[0-9]{2,3}$/ui', 'message' => 'Введите гос номер автомобиля на русском без пробелов'],
        ];
    }

    public function validFields()
    {
        return true;
    }

    public function checkUser()
    {
        $mailer = new UnioneMailer();

        $user = Accs::find()->where(['email' => $this->email])->one();
        if (!empty($user->email) && $user->email == $this->email) {
            $user->verifyCode = $this->getVeriFyCode();
            $user->save();
            $mailer->sendVerifyCode($user, $user->verifyCode);
            return ['code' => $user->verifyCode];
        } else {
            $registration = new RegistrationUsers();
            $registration->email = $this->email;
            $registration->promocode = $this->promocode;
            $registration->lang = $this->lang;
            $registration->password = $this->pass;
            $registration->source = $this->source;
            $registration->country = $this->country;
            $registration->verifyCode = (string)$this->getVeriFyCode();
            if ($registration->save()) {
                $mailer->sendVerifyCode($registration, $registration->verifyCode);
            } else {
                return $registration->errors;
            }
            return ['code' => $registration->verifyCode];
        }
    }

    public function create()
    {
        $this->using_promocode = $this->promocode;
        return $this->checkUser();
    }

    public function checkEmail()
    {
        $user = Accs::find()->where(['email' => $this->email])->one();
        if (!empty($user->email) && $user->email == $this->email) {
            if ($user->status == \app\models\VpnUserSettings::$statuses['DELETED']) {
                $user->status = VpnUserSettings::$statuses['ACTIVE'];
                $user->pass = $this->pass;
                $user->save();

                $userModel = \app\models\user\User::find()->where(['email' => $this->email])->one();
                $userModel->password_hash = Yii::$app->security->generatePasswordHash($this->pass);
                $userModel->save();

                return $this->login();
            } else {
                $this->addError('email', 'This email address has already been taken');
                return false;
            }
        }
        return false;
    }

    public function createUser()
    {
        $this->using_promocode = $this->promocode;
        if ($thisUser = $this->checkEmail()) {
            return $thisUser;
        }
        $this->generateVpnKey();
        $vpnModel = new VpnUserSettings();
        $vpnModel->username = $this->vpnLogin;
        $vpnModel->value = $this->vpnPassword;
        $vpnModel->createAdmin = false;
        if ($vpnModel->save()) {
            $usedPromocode = false;
            $user = new User();
            $user->module->enableConfirmation = false;
            $user->email = $this->email;
            $user->username = $this->email;
            $user->password = $this->pass;
            $code = $this->getVeriFyCode();
            $_SESSION['code'] = $code;
            if ($user->register()) {

                $this->status = \app\models\VpnUserSettings::$statuses['ACTIVE'];
                $this->vpnid = $vpnModel->id;
                $this->user_id = $user->id;
                $this->role = 'user';
                $this->tariff = 'Free';
                $this->source = 'mobil';
                $this->datecreate = time();
                $this->untildate = time();
                $this->used_promocode = $this->using_promocode;
                $this->promocode = Yii::$app->security->generateRandomString(6);
                $this->verifyCode = $code;
                $this->pass = Yii::$app->security->generatePasswordHash($this->pass);
                if ($this->phone) {
                    if (!($profile = Profile::find()->where(['user_id' => $user->id])->one())) {
                        $profile = new Profile();
                        $profile->user_id = $user->id;
                    }
                    $profile->phone = $this->phone;
                    $profile->save();
                }
                if ($this->save()) {
                    /* +1 promocode */
                    $usedPromocode = false;
                    if ($this->using_promocode) {
                        $usedPromocode = Accs::setPromoShareCount($this->using_promocode, $user);
                    }
                    if ($usedPromocode) {
                        /* add event */
                        $event = new UserEvents();
                        $event->event = (string)UserEvents::EVENT_REGISTRATION_PROMOCODE;
                        $event->user_id = $user->id;
                        $event->text = 'регистрация по промо-коду : ' . $this->using_promocode;
                        $event->save(false);
                    }
                    $accs = self::find()->where(['email' => $this->email])->one();

                    return [
                        "id" => (int)$accs->id,
                        "email" => $accs->email,
                        "promocode" => $accs->promocode,
                        "pass" => $accs->pass,
                        "verifyCode" => (int)$accs->verifyCode,
                        "status" => $accs->status,
                        "vpnid" => (int)$accs->vpnid,
                        "user_id" => (int)$accs->user_id,
                        "role" => $accs->role,
                        "tariff" => $accs->tariff,
                        "datecreate" => (int)$accs->datecreate,
                        "untildate" => (int)$accs->untildate,
                        "used_promocode" => $accs->used_promocode,
                    ];
                } else {
                    return false;
                }
            } else {
                return $user->errors;
            }

        }
        return false;

    }


    public function updateUser($chatId, $server, $email)
    {
        $accs = self::find()->where(['chatId' => $chatId])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
        if (!empty($accs)) {
            $userAccs = Accs::find()->where(['chatId' => $chatId])->one();
            if ($server) {
                $userAccs->country = $server;
            }
            if ($email) {
                $userAccs->email = $email;
                $_SESSION['code'] = $userAccs->verifyCode;
                $user = Yii::createObject(User::className());
                $user->setScenario('register');
//                $user->setAttributes([
//                    'email' => $email,
//                    'username' => $email,
//                    'password' => $userAccs->pass
//                ]);
                $user->email = $email;
                $user->username = $email;
                $user->password = $userAccs->pass;
                $user->register();
                $userModel = \app\models\user\User::find()->where(['email' => $email])->one();
                if (!empty($userModel)) {
                    $userAccs->user_id = $userModel->id;
                }
            }
            $userAccs->save(false);
            return [
                'id' => $accs->id,
                'email' => $accs->email,
                'pass' => $accs->pass,
                'status' => $accs->status,
                'country' => $userAccs->country,
                'untildate' => $accs->untildate,
                'vpnLogin' => $accs->radcheck->username,
                'vpnPassword' => $accs->radcheck->value,
            ];
        }
    }

    public function createBaseUser()
    {
        $this->using_promocode = $this->promocode;

        $this->generateVpnKey();
        $vpnModel = new VpnUserSettings();
        $vpnModel->username = $this->vpnLogin;
        $vpnModel->value = $this->vpnPassword;
        $vpnModel->createAdmin = false;
        if ($vpnModel->save()) {

            $code = $this->getVeriFyCode();
            $_SESSION['code'] = $code;

            $this->status = \app\models\VpnUserSettings::$statuses['ACTIVE'];
            $this->vpnid = $vpnModel->id;
            $this->user_id = 0;
            $this->role = 'user';

            $telegramUser = TelegramUsers::find()->where(['chat_id' => $this->email])->one();

            $this->tariff = 'Free';
            $this->untildate = time();
            $this->datecreate = time();

            $this->used_promocode = $this->using_promocode;
            $this->promocode = Yii::$app->security->generateRandomString(6);
            $this->chatId = $this->email;
            $this->verifyCode = $code;
            if ($this->save(false)) {
                if (!empty($telegramUser->ref)) {
                    $this->tariff = 'Premium';
                    $usedPromocode = Accs::setPromoShareCount($telegramUser->ref, $this, $this->chatId);
                    if ($usedPromocode === true) {
                        $this->used_promocode = $telegramUser->ref;
                    } else {
                        $this->untildate = time() + 24 * 3 * 3600;
                    }
                    $this->save(false);
                }
                return [
                    'vpnId' => $this->vpnid,
                    'email' => $this->email,
                    'pass' => $this->pass,
                    'vpnLogin' => $vpnModel->username,
                    'vpnPassword' => $vpnModel->value,
                ];
            } else {
                return false;
            }

        }
        return false;

    }

    /**
     * @return void
     * @throws \yii\base\Exception
     */
    public function generateVpnKey()
    {
        $this->vpnPassword = self::RandomToken();
        $this->vpnLogin = Yii::$app->security->generateRandomString(10);
    }

    /**
     * @param $email
     * @param $code
     * @return array|boolean
     */
    public function checkVerifyCode($email, $code)
    {
        $user = self::find()->where(['email' => $email, 'verifyCode' => $code])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();;
        $model = \Yii::createObject(LoginForm::className());
        if ($this->pass) {
            $model->load(['login' => $this->email, 'password' => $this->pass], '');
            $login = $model->login();
            if (!$login) {
                $this->addError('email', 'Пользователь не найдено или пароль не верный');
                return false;
            }
        }
        if (empty($user)) {
            $registration = RegistrationUsers::find()->where(['email' => $email, 'verifyCode' => $code])->one();
            if (empty($registration)) {
                $this->addError('email', 'Пользователь не найдено или пароль не верный');
                return false;
            }
            $model = new self();
            $model->email = $email;
            $model->pass = $registration->password ?? rand(0, 999999);
            $model->promocode = $registration->promocode;
            $model->source = $registration->source;
            $model->country = $registration->country;
            return $model->createUser();
        };
        $userData = [
            'id' => $user->id,
            'email' => $user->email,
            'pass' => $user->pass,
            'tariff' => $user->tariff,
            'background_work' => $user->background_work ?? 0,
            'test_user' => $user->test_user ?? 0,
            'status' => $user->status,
            'promocode' => $user->promocode,
            'ios_token' => $user->ios_token,
            'fcm_token' => $user->fcm_token,
            'untildate' => $user->untildate,
            'vpnLogin' => $user->radcheck->username,
            'vpnPassword' => $user->radcheck->value,
        ];

        return $userData;
    }

    /**
     * @return array|false|\yii\db\ActiveRecord
     */
    public function login()
    {
        $user = self::find()->where(['email' => $this->email, 'verifyCode' => $this->verifyCode])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
        $login = [];
        $model = \Yii::createObject(LoginForm::className());
        if ($this->pass) {
            $model->load(['login' => $this->email, 'password' => $this->pass], '');
            $login = $model->login();
            $user = self::find()->where(['email' => $this->email])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
            if (!$login) {
                $this->addError('email', 'Пользователь не найдено или пароль не верный3');
                return false;
            }
        }
        if (empty($user) && empty($login)) {
            $registration = RegistrationUsers::find()->where(['email' => $this->email, 'verifyCode' => $this->verifyCode])->one();
            if (empty($registration)) {
                $this->addError('email', 'Пользователь не найдено или пароль не верный_');
                return false;
            }
            $model = new self();
            $model->email = $this->email;
            $model->pass = $registration->password ?? rand(0, 999999);
            $model->promocode = $registration->promocode;
            $model->source = $registration->source;
            $model->country = $registration->country;
            $result =  $model->createUser();
            if(empty($result)) {

            }
            $user = self::find()->where(['email' => $result['email']])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
            $user->untildate = date("Y-m-d", $user->untildate) > date("Y-m-d") ? ($user->untildate + (3600 * 24 * 3)) : strtotime('+ 3 days');
            $user->save();
        };

        if ($this->fcm_token || $this->ios_token) {
            if ($this->ios_token) {
                $user->source = 'ios';
            }
            if ($this->fcm_token) {
                $user->source = 'android';
            }
            $user->save();
        }

        if ($this->deviceId) {

            if (!$tokens = UserTokens::find()->where(['deviceid' => $this->deviceId])->one()) {
                $tokens = UserTokens::find()->where(['deviceid' => $this->deviceId])->one();
            }
            if (empty($tokens)) {
                $tokens = new UserTokens();
                $tokens->status = 1;
                $tokens->deviceid = $this->deviceId;
                $tokens->user_id = $user->user_id;
                $tokens->auth_key = self::RandomToken(32);
                $user->save();
            }
            if ($this->fcm_token || $this->ios_token) {
                if ($this->ios_token) {
                    $tokens->token = $this->ios_token;
                }
                if ($this->fcm_token) {
                    $tokens->token = $this->fcm_token;
                }
            }
            $tokens->source = $this->source ? $this->source : $tokens->source;
            $tokens->name = $this->source_name ? $this->source_name : $tokens->name;
            $tokens->language = $this->language ? $this->language : $tokens->language;
            $tokens->version = $this->version ? $this->version : $tokens->version;
            $tokens->last_login = date("Y-m-d H:i:s");
            $tokens->save();

        }
        $userModel = User::findOne($user->user_id);
        $userData = [
            'id' => $user->user_id,
            'email' => $user->email,
            'pass' => $user->pass,
            'tariff' => $user->tariff,
            'background_work' => $user->background_work ?? 0,
            'test_user' => $user->test_user ?? 0,
            'status' => $user->status,
            'promocode' => $user->promocode,
            'ios_token' => $user->ios_token,
            'fcm_token' => $user->fcm_token,
            'untildate' => $user->untildate,
            'vpnLogin' => $user->radcheck->username,
            'vpnPassword' => $user->radcheck->value,
            'auth_key' => !empty($tokens->auth_key) ? $tokens->auth_key : ($userModel->auth_key ?? "")
        ];

        return $userData;
    }

    /**
     * @return array|false|\yii\db\ActiveRecord
     */
    public function check()
    {
        $user = self::find()->where(['username' => $this->vpnLogin, 'value' => $this->vpnPassword])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
        if (empty($user)) {
            $this->addError('username', 'Пользователь не найдено или пароль не верный');
            return false;
        };
        if (!empty($user) && (strtolower($user->status) == strtolower(VpnUserSettings::$statuses['DELETED']) || strtolower($user->status) == strtolower(VpnUserSettings::$statuses['NOACTIVE']))) {
            $userData = [
                'message' => 'юзер не в статусе active',
                'status' => $user->status,
            ];
            return $userData;
        }
        $userData = [
            'status' => $user->status,
            'untildate' => date("Y-d-m h:i:s", $user->untildate),
        ];

        return $userData;
    }

    public function push()
    {
        $user = self::find()->where(['id' => $this->id, 'pass' => $this->pass])->one();
        if (!empty($user)) {
            $user->fcm_token = $this->fcm_token;
            $user->ios_token = $this->ios_token;
            $user->save();
            return true;
        }
        return false;
    }

    public function recoverUser($email)
    {
        $user = self::find()->where(['email' => $email])->one();
        $userSite = User::find()->where(['email' => $email])->one();
        if (empty($user)) {
            $this->email = $email;
            $this->pass = Yii::$app->security->generateRandomString(8);
            if ($this->createUser()) {
                $subject = 'Добро пожаловать в VPN MAX';
                $body = '<p>Здравствуйте, Ваш аккаунт на сайте "VPN MAX" был успешно создан</p> Ваш пароль: ' . $this->pass;
                $this->sendMail($subject, $body);
            }
            return "Вам отправлено письмо с доступами";
        }
        $password = Yii::$app->security->generateRandomString(8);
        $user->pass = $password;
        $user->reset_pass = $password;
        $userSite->password_hash = Yii::$app->security->generatePasswordHash($password);
        if ($user->save() && $userSite->save()) {
            $subject = 'Восстановления пароль пользователя в VPN MAX';
            $body = 'Ваш новый пароль: ' . $password;
            $this->sendMail($subject, $body);
            return "пароль отправлен на почту";
        }
        $this->errorResponse('не удалось восстановить пароль');
    }

    public function getUserDataByChatId($chatId)
    {
        $user = self::find()->where(['chatId' => $chatId])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
        if (empty($user)) return false;
        $userData = [
            'id' => $user->id,
            'email' => $user->email,
            'pass' => $user->pass,
            'status' => $user->status,
            'tariff' => $user->tariff,
            'country' => $user->country,
            'untildate' => $user->untildate,
            'countDay' => (\app\components\DateFormat::countDays($user->untildate)),
            'user_id' => $user->user_id,
            'vpnLogin' => $user->radcheck->username,
            'vpnPassword' => $user->radcheck->value,
        ];

        return $userData;
    }

    public function deleteUser()
    {
        $user = self::find()->where(['email' => $this->email, 'pass' => $this->pass])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
        if (!empty($user)) {
            $user->status = VpnUserSettings::$statuses['DELETED'];
            $user->save();
            $userData = [
                'id' => $user->id,
                'email' => $user->email,
                'pass' => $user->pass,
                'tariff' => $user->tariff,
                'background_work' => $user->background_work,
                'status' => $user->status,
                'ios_token' => $user->ios_token,
                'fcm_token' => $user->fcm_token,
                'untildate' => $user->untildate,
                'vpnLogin' => $user->radcheck->username,
                'vpnPassword' => $user->radcheck->value,
            ];
        } else {
            $this->addError('username', 'Пользователь не найдено или пароль не верный');
            return false;
        }
        return $userData;
    }

    public function errorResponse($errors)
    {
        throw new \yii\web\HttpException(500, $errors);
    }

    public function notFoundPassResponse($errors)
    {
        throw new \yii\web\HttpException(404, $errors);
    }

    /**
     * @param $length
     * @return string|void
     * @throws \Exception
     */
    public static function RandomToken($length = 16)
    {
        if (!isset($length) || intval($length) <= 8) {
            $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, 1));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }

    /**
     * @param $subject
     * @param $body
     * @return void
     * @throws \yii\web\HttpException
     */
    public function sendMail($subject, $body)
    {

        try {
            \Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setTo([$this->email])
                ->setSubject($subject)
                ->setHtmlBody($body)
                ->send();
        } catch (\Swift_TransportException $exception) {
            $this->errorResponse($exception->getMessage());
        }
        $history = new MailHistory();
        $history->body = $body;
        $history->subject = $subject;
        $history->email = $this->email;
        $history->datecreate = date("Y-m-d H:i:s");
        $history->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadcheck()
    {
        return $this->hasOne(VpnUserSettings::className(), ['id' => 'vpnid']);
    }

    public function getCode()
    {
        $user = self::find()->where(['email' => $this->email])->one();
        if (empty($user)) {
            return $user->errors;
        }
        $user->verifyCode = $this->getVeriFyCode();
        if ($user->save()) {
            $this->sendMail('Код активации', 'Новый код активации: ' . $user->verifyCode);
            return "Код активации отправлен на почту";
        }
        return false;
    }

    public function getVeriFyCode()
    {
        return rand(111111, 999999);
    }
}
