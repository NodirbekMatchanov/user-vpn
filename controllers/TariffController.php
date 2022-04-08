<?php

namespace app\controllers;

use app\models\Accs;
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
                        'actions' => ['list','create', 'update', 'delete','view'],
                        'allow' => User::checkAccess(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'payment', 'get-price','payment-success'],
                        'allow' => true,
                        'roles' => ['@'],
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

        return $this->render('index', [
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
        $type = \Yii::$app->request->get('type');
        if ($type) {
            switch ($type) {
                case 'basic' :
                    return 100;
                    break;
                case 'premium' :
                    return 1000;
            }
        }
        throw new BadRequestHttpException('not type');
    }


    public function actionPaymentSuccess()
    {
        $status = \Yii::$app->request->post('status');
        if ($status) {

            $payment = new Payments();
            $payment->status = $status ? Payments::PAYED : Payments::ERROR;
            $payment->orderId = \Yii::$app->request->post('orderId') ;
            $payment->user_id = \Yii::$app->user->identity->getId() ;
            $payment->tariff = \Yii::$app->request->post('tariff') ;
            $payment->amount =  \Yii::$app->request->post('amount') ;
            $payment->save();

            if($payment->status == Payments::PAYED){
                $accs = Accs::find()->where(['user_id' => \Yii::$app->user->identity->getId()])->one();
                $accs->untildate = $payment->tariff == 'basic' ? strtotime("+30 days") : strtotime("+365 days");
                $accs->tariff = $payment->tariff == 'basic' ? VpnUserSettings::$tariffs['Premium'] : VpnUserSettings::$tariffs['VIP'];
                if($accs->save()) {
                    echo json_encode($accs->tariff); die;
                }
                echo json_encode($accs->errors); die;
            }
        }
        throw new BadRequestHttpException('not payed');
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
        return $this->render('view', [
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

        return $this->redirect(['control/index']);
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