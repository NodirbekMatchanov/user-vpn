<?php

namespace app\controllers;

use app\models\Country;
use app\models\Questions;
use app\models\Tariff;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['pay','index','error','login','privacy','question','success'],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main_';
        $tariffs = Tariff::find()->all();
        return $this->render('index',[
            'tariffs' => $tariffs,
        ]);
    }

    public function actionPay()
    {
        file_put_contents("pay.txt",json_encode($_GET));
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ["code" => 0];
    }

    public function actionSuccess()
    {
        $this->layout = 'main_';
        return $this->render('success',[
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->isAdmin()){
               return $this->redirect(['/user/settings/account']);
            }
           return $this->redirect(['/user/settings/account']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->isAdmin()){
              return  $this->redirect('/vpn-user-settings/index');
            } else {
               return $this->redirect('/user/settings/account');
            }
        }

        $model->password = '';
        return $this->redirect(['user/login']);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionQuestion()
    {
        $model = new Questions();
        echo "asd";
        if ($model->load(Yii::$app->request->post(),'') && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return true;
        }
        return false;
    }

    public function actionError()
    {
        $this->layout = 'main_';
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
//        $cty =  Country::find()->all();
//        foreach ($cty as $item) {
//            $path = Yii::getAlias('@app/web/flags/').'/'.$item->code.'.png';
//            if(file_exists($path)) {
//                copy($path,Yii::getAlias('@app/web/flags_ru/').'/'.str_replace(" ","_",$item->title).'.png');
//            }
//        }
        return $this->render('about');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionPrivacy()
    {
        $this->layout = 'main_';
        return $this->render('privacy');
    }

    public function actionQuestions()
    {
        $model = new \app\models\Questions();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('questions', [
            'model' => $model,
        ]);
    }
}
