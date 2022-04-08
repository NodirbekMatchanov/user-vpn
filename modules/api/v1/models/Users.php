<?php

namespace app\modules\api\v1\models;

use app\components\DateFormat;
use app\models\Accs;
use app\models\MailHistory;
use app\models\user\Profile;
use dektrium\user\models\LoginForm;
use http\Message;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\models\VpnUserSettings;
use dektrium\user\models\User;

class Users extends \yii\db\ActiveRecord
{
    public $vpnLogin;
    public $vpnPassword;
    public $phone;

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
            [['email', 'pass'], 'required'],
            [['role', 'promocode','fcm_token','ios_token', 'phone','status', 'email',], 'string', 'max' => 255],
            [['vpnid','id', 'verifyCode', 'user_id'], 'integer'],
            ['email', 'unique'],
            ['datecreate', 'safe'],
//            ['avtoNumber', 'match', 'pattern' => '/^[а-яА-Я]{1}\s?[0-9]{3}\s?[а-яА-Я]{2}\s?[0-9]{2,3}$/ui', 'message' => 'Введите гос номер автомобиля на русском без пробелов'],
        ];
    }

    public function validFields()
    {
        return true;
    }

    public function createUser()
    {
        $this->generateVpnKey();
        $vpnModel = new VpnUserSettings();
        $vpnModel->username = $this->vpnLogin;
        $vpnModel->value = $this->vpnPassword;
        if ($vpnModel->save()) {

            $user = new User();
            $user->email = $this->email;
            $user->username = $this->email;
            $user->password = $this->pass;

            if ($user->register()) {
                $this->status = \app\models\VpnUserSettings::$statuses['NOACTIVE'];
                $this->vpnid = $vpnModel->id;
                $this->user_id = $user->id;
                $this->role = 'user';
                $this->datecreate = time();
                $this->untildate = time();
                $this->promocode = Yii::$app->security->generateRandomString(6);
                $this->verifyCode = $this->getVeriFyCode();
                if($this->phone){
                    if(!($profile = Profile::find()->where(['user_id' => $user->id])->one())){
                        $profile = new Profile();
                        $profile->user_id = $user->id;
                    }
                    $profile->phone = $this->phone;
                    $profile->save();
                }
                if ($this->save()) {
                    return $this;
                } else {
                    return false;
                }
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
        $this->vpnLogin = Yii::$app->security->generateRandomString(16);
    }

    /**
     * @param $email
     * @param $code
     * @return bool
     */
    public function checkVerifyCode($email, $code)
    {
        $user = self::find()->where(['email' => $email, 'verifyCode' => $code])->one();
        if (empty($user)) return false;
        $user->status = VpnUserSettings::$statuses['ACTIVE'];
        $user->untildate = strtotime('+ 3 days');
        $user->save();
        return "user activated";
    }

    /**
     * @return array|false|\yii\db\ActiveRecord
     */
    public function login()
    {
        $user = self::find()->where(['email' => $this->email, 'pass' => $this->pass])->leftJoin(VpnUserSettings::tableName(), 'radcheck.id = accs.vpnid')->one();
        $model = \Yii::createObject(LoginForm::className());
        $model->load(['login' => $this->email,'password' => $this->pass],'');
        $login = $model->login();
        if (empty($user) || !$login) {
            $this->addError('email', 'Пользователь не найдено или пароль не верный');
            return false;
        };
        if (!empty($user) && (strtolower($user->status) == strtolower(VpnUserSettings::$statuses['DELETED']) || strtolower($user->status) == strtolower(VpnUserSettings::$statuses['NOACTIVE']))) {
            $this->addError('email', 'Пользователь не активный. Завершите активацию учетной записи');
            return false;
        }
        /*если юзер в статусе не активирован пытается сменить пароль, то менять ему пароль, и если он по нему залогинится,
         то автоматически ставить статус активирован.*/
        if ($user->reset_pass == $this->pass) {
            $user->status = VpnUserSettings::$statuses['ACTIVE'];
            $user->reset_pass = '';
            $user->save();
        }

        if($this->fcm_token || $this->ios_token){
            $user->fcm_token = $this->fcm_token;
            $user->ios_token = $this->ios_token;
            $user->save();
        }

        $userData = [
            'id' => $user->id,
            'email' => $user->email,
            'pass' => $user->pass,
            'tariff' => $user->tariff,
            'status' => $user->status,
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

    public function push(){
        $user = self::find()->where(['id' => $this->id,'pass' => $this->pass])->one();
        if(!empty($user)){
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
        $userSite =  User::find()->where(['email' => $email])->one();
        if (empty($user)) {
            $this->addError('email', 'user email not found');
        }
        $password = Yii::$app->security->generateRandomString(8);
        $user->pass = $password;
        $user->reset_pass = $password;
        $userSite->password_hash = Yii::$app->security->generatePasswordHash($password);
        if ($user->save() && $userSite->save()) {
            $subject = 'Восстановления пароль пользователя в vpnMax.org';
            $body = 'Ваш новый пароль: ' . $password;
            $this->sendMail($subject, $body);
            return "пароль отправлен на почту";
        }
        $this->errorResponse('не удалось восстановить пароль');
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
                ->setFrom('welcome@vpnmax.org')
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
