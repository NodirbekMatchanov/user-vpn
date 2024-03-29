<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers\user;

use app\models\Accs;
use app\models\LoginForm;
use app\models\Mailer;
use app\models\RegistrationUsers;
use app\models\user\VerifyCode;
use app\modules\api\v1\models\VpnUserSettings;
use dektrium\user\Finder;
use app\models\user\RegistrationForm;
use dektrium\user\models\ResendForm;
use dektrium\user\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RegistrationController is responsible for all registration process, which includes registration of a new account,
 * resending confirmation tokens, email confirmation and registration via social networks.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationController extends Controller
{
    use AjaxValidationTrait;
    use EventTrait;

    /**
     * Event is triggered after creating RegistrationForm class.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_BEFORE_REGISTER = 'beforeRegister';

    /**
     * Event is triggered after successful registration.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_REGISTER = 'afterRegister';

    /**
     * Event is triggered before connecting user to social account.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_CONNECT = 'beforeConnect';

    /**
     * Event is triggered after connecting user to social account.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONNECT = 'afterConnect';

    /**
     * Event is triggered before confirming user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_CONFIRM = 'beforeConfirm';

    /**
     * Event is triggered before confirming user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONFIRM = 'afterConfirm';

    /**
     * Event is triggered after creating ResendForm class.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_BEFORE_RESEND = 'beforeResend';

    /**
     * Event is triggered after successful resending of confirmation email.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_RESEND = 'afterResend';

    /** @var Finder */
    protected $finder;

    /**
     * @param string $id
     * @param \yii\base\Module $module
     * @param Finder $finder
     * @param array $config
     */
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    /** @inheritdoc */
    public function behaviors()
    {
        $params = http_build_query(\Yii::$app->request->get());
        header('Location: '. \Yii::$app->params['backendUrl'].'/user/register?'.$params); die();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['register', 'auto-register', 'connect', 'verify-code'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['confirm', 'auto-register', 'resend'], 'roles' => ['?', '@']],
                ],
            ],

        ];
    }

    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        $this->layout = "@app/views/layouts/main_.php";

        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }
        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);

        /*если в куки есть промокод то передаем в модель*/
        if (isset($_COOKIE['promocode'])) {
            $model->promocode = $_COOKIE['promocode'];
        }

        if ($model->load(\Yii::$app->request->post()) && $model->temporaryRegister()) {
//            $this->trigger(self::EVENT_AFTER_REGISTER, $event);
           return $this->redirect(['registration/verify-code']);
        }

        return $this->render('register', [
            'model' => $model,
            'module' => $this->module,
        ]);
    }

    public function actionAutoRegister()
    {
        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);

        /*если в куки есть промокод то передаем в модель*/
        if (isset($_COOKIE['promocode'])) {
            $model->promocode = $_COOKIE['promocode'];
        }

        if ($model->load(\Yii::$app->request->get(), '') && $model->register()) {
            $this->trigger(self::EVENT_AFTER_REGISTER, $event);
            return true;
        } else {
            return json_encode($model->errors);
        }

    }

    public function actionVerifyCode()
    {

        $this->layout = "@app/views/layouts/main_.php";
        $verifyCode = new VerifyCode();

        if ($verifyCode->load(\Yii::$app->request->post()) && $verifyCode->validate()) {
            $user = RegistrationUsers::find()->where(['verifyCode' => $verifyCode->code])->orderBy('id desc')->one();
            if(!empty($user)) {
                $accs = Accs::find()->where(['email' => $user->email])->one();
                if(!empty($accs)) {
                    $finder = new Finder();
                    \Yii::$app->getUser()->login($finder->findUserByUsernameOrEmail($user->email), 0);
                    return $this->goBack();
                }
                \Yii::$app->getSession()->setFlash('success', 'Ваш аккаунт успешно активирован!');
                $model = \Yii::createObject(RegistrationForm::className());
                $event = $this->getFormEvent($model);

                $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

                $this->performAjaxValidation($model);

                /*если в куки есть промокод то передаем в модель*/
                if (isset($_COOKIE['promocode'])) {
                    $model->promocode = $_COOKIE['promocode'];
                }

                $data = [
                    'email' => $user->email,
                    'username' => $user->email,
                    'password' => $user->password,
                    'promocode' => $user->promocode,
                    'phone' => $user->phone,
                    'password_repeat' => $user->password,
                ];
                if ($model->load($data, '') && $model->register()) {
                    $accs = Accs::find()->where(['email' => $user->email])->one();
                    $accs->status = VpnUserSettings::$statuses['ACTIVE'];
                    $accs->save();
                }
                $model = new LoginForm();
                if ($model->load(['username' => $user->email, 'password' => $user->password], '') && $model->login()) {

//                    $accs = Accs::find()->where(['email' => $verifyCode->user->email])->one();
//                    $accs->untildate = date("Y-m-d", $accs->untildate) <= date("Y-m-d") ? strtotime('+ 3 days') : ($accs->untildate + (24 * 3600 * 3));
//                    $accs->save();
                    return $this->redirect('/user/settings/account', 303);
                }
            }

            $this->redirect(['/user/settings/account']);
        }
        return $this->render('veriFyCode', [
            'title' => \Yii::t('user', 'Your account has been created'),
            'module' => $this->module,
            'verifyCode' => $verifyCode,
        ]);
    }

    /**
     * Displays page where user can create new account that will be connected to social account.
     *
     * @param string $code
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionConnect($code)
    {
        $account = $this->finder->findAccount()->byCode($code)->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = \Yii::createObject([
            'class' => User::className(),
            'scenario' => 'connect',
            'username' => $account->username,
            'email' => $account->email,
        ]);

        $event = $this->getConnectEvent($account, $user);

        $this->trigger(self::EVENT_BEFORE_CONNECT, $event);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            $account->connect($user);
            $this->trigger(self::EVENT_AFTER_CONNECT, $event);
            \Yii::$app->user->login($user, $this->module->rememberFor);
            return $this->goBack();
        }

        return $this->render('connect', [
            'model' => $user,
            'account' => $account,
        ]);
    }

    /**
     * Confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
     * shows error message.
     *
     * @param int $id
     * @param string $code
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);
        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

        $user->attemptConfirmation($code);

        $accs = Accs::find()->where(['user_id' => $user->id])->one();
        $accs->status = VpnUserSettings::$statuses['ACTIVE'];
        $accs->untildate = date("Y-m-d", $accs->untildate) <= date("Y-m-d") ? strtotime('+ 3 days') : ($accs->untildate + (24 * 3600 * 3));
        $accs->save();

        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);
        $mailer = new Mailer();
        $mailer->sendActivateAccount($accs);

        \Yii::$app->getSession()->setFlash('success', 'Ваш аккаунт успешно активирован!');
        return $this->render('/message', [
            'title' => "Ваш аккаунт успешно активирован!",
            'module' => $this->module,
            'redirect' => 1,
        ]);

    }

    /**
     * Displays page where user can request new confirmation token. If resending was successful, displays message.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionResend()
    {
        if ($this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        /** @var ResendForm $model */
        $model = \Yii::createObject(ResendForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_RESEND, $event);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->resend()) {
            $this->trigger(self::EVENT_AFTER_RESEND, $event);

            return $this->render('/message', [
                'title' => \Yii::t('user', 'A new confirmation link has been sent'),
                'module' => $this->module,
            ]);
        }

        return $this->render('resend', [
            'model' => $model,
        ]);
    }
}
