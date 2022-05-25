<?php

namespace app\controllers;

use app\models\Accs;
use app\models\Mailer;
use app\models\Payments;
use app\models\Support;
use app\models\SupportSearch;
use app\models\Tariff;
use app\models\TariffSearch;
use app\models\user\User;
use app\models\VpnUserSettings;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

class TariffController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'create', 'update', 'delete', 'view'],
                        'allow' => User::checkAccess(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [ 'payment', 'get-price', 'payment-success', 'payment-error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Lists all Support models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tariffs = Tariff::find()->where(['status' => Tariff::ACTIVE])->all();
        return $this->render('index', [
            'model' => $tariffs
        ]);
    }

    public function actionPayment()
    {
        return $this->render('payment', [
        ]);
    }

    /**
     * @return int
     * @throws BadRequestHttpException
     */
    public function actionGetPrice()
    {
        $id = \Yii::$app->request->get('id');
        $orderId = \Yii::$app->request->get('orderId');
        $promocode = \Yii::$app->request->get('promocode') ?? "";
        if ($id) {
            $tariffs = Tariff::find()->all();
            $price = 0;
            foreach ($tariffs as $tariff){
                if ($id == '1_month'){
                    $price = $tariff->price_30;
                }  else if ($id == '6_month')
                {
                    $price = $tariff->price_180;
                } else if ($id == '12_month')
                {
                    $price = $tariff->price_365;
                }
            }
            if($orderId){
                $payment = new Payments();
                $payment->status = "0";
                $payment->orderId = $orderId;
                $payment->user_id = \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->getId();
                $payment->tariff = $id;
                $payment->amount = $price;
                $payment->promocode = $promocode;
                $payment->save();
            }
            return  $price;
        }
        throw new BadRequestHttpException('not found tariff');
    }


    public function actionPaymentSuccess()
    {
        $status = \Yii::$app->request->post('status');
        $amount = \Yii::$app->request->post('amount');
        $code = \Yii::$app->user->identity->promoCodes;

        if ($status && $id = \Yii::$app->request->post('tariff')) {
            $tariff = Tariff::findOne($id);
            if (empty($tariff) || $tariff->price != $amount) {
                throw new BadRequestHttpException('not payed');
            }
            $payment = new Payments();
            $payment->status = $status ? Payments::PAYED : Payments::ERROR;
            $payment->orderId = \Yii::$app->request->post('orderId');
            $payment->user_id = \Yii::$app->user->identity->getId();
            $payment->tariff = \Yii::$app->request->post('tariff');
            $payment->amount = $amount;
            $payment->save();

            if ($payment->status == Payments::PAYED) {
                $accs = Accs::find()->where(['user_id' => \Yii::$app->user->identity->getId()])->one();
                $accs->untildate = strtotime("+" . $tariff->period . " days");
                $accs->tariff = $tariff->name;
                $accs->background_work = true;
                if ($accs->save()) {
                    echo json_encode($accs->tariff);
                    die;
                }
                echo json_encode($accs->errors);
                die;
            }
        }
        throw new BadRequestHttpException('not payed');
    }

    public function actionPaymentError()
    {
        $status = \Yii::$app->request->post('status');
        $amount = \Yii::$app->request->post('amount');
        $code = \Yii::$app->user->identity->promoCodes;
        $payment = new Payments();
        $payment->status = Payments::ERROR;
        $payment->orderId = \Yii::$app->request->post('orderId');
        $payment->user_id = \Yii::$app->user->identity->getId();
        $payment->tariff = \Yii::$app->request->post('tariff');
        $payment->amount = $amount;
        $payment->save();
        $mailer = new Mailer();
        $user = User::find()->where(['id' => \Yii::$app->user->identity->getId()])->one();
        $mailer->sendErrorPaymentMessage($user);
    }

    /**
     * Lists all Tariff models.
     *
     * @return string
     */
    public function actionList()
    {
        $searchModel = new TariffSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('control/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tariff model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('control/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tariff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tariff();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('control/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tariff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('control/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tariff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    /**
     * Finds the Tariff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tariff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tariff::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}