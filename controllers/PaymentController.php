<?php

namespace app\controllers;

use app\models\Accs;
use app\models\Payments;
use app\models\PaymentsSearch;
use app\models\Tariff;
use app\models\User;
use app\models\user\RegistrationForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaymentController implements the CRUD actions for Payments model.
 */
class PaymentController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Payments models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PaymentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payments model.
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
     * Creates a new Payments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Payments();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Payments model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Payments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Payments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSuccessPay()
    {
        file_put_contents("pay.txt", json_encode($_GET));
        if (\Yii::$app->request->get('InvoiceId')) {
            $data = \Yii::$app->request->get();
            if ($order = Payments::find()->where(['orderId' => $data['InvoiceId']])->one()) {
                if ($data['Status'] == "Completed" && (int)$order->amount == (int)$data['Amount']) {
                    $order->status = Payments::PAYED;
                    $order->save();
                    if (!empty($data['Email'])) {
                        $hasUser = Accs::find()->where(['email' => $data['Email']])->one();
                        if (empty($hasUser)) {
                            $password = \Yii::$app->security->generateRandomString(8);
                            $userData = [
                                'email' =>  $data['Email'],
                                'password' =>  $password,
                                'password_repeat' =>  $password,
                            ];

                            /** @var RegistrationForm $model */
                            $model = \Yii::createObject(RegistrationForm::className());

                            /*если в куки есть промокод то передаем в модель*/
                            if (isset($_COOKIE['promocode'])) {
                                $model->promocode = $_COOKIE['promocode'];
                            }

                            if ($model->load($userData, '') && $model->register()) {
                                $user = Accs::find()->where(['email' => $data['Email']])->one();
                                $time = Tariff::getPeriod($order->tariff) * (3600 * 24);
                                $user->untildate = $user->untildate < time() ? (time() + $time) : $user->untildate + $time ;
                            } else {
                                return $model->errors;
                            }

                        } else {

                        }
                    }
                }
            }
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ["code" => 0];
    }



    public function actionCancelPay()
    {
        file_put_contents("cancel.txt", json_encode($_GET));
        if (\Yii::$app->request->get('InvoiceId')) {
            $data = \Yii::$app->request->get();
            if ($order = Payments::find()->where(['orderId' => $data['InvoiceId']])) {
                if ($data['Status'] == "Completed" && (int)$order->amount == (int)$data['Amount']) {
                    $order->status = Payments::PAYED;
                    $order->save();

                }
            }
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ["code" => 0];
    }
}
