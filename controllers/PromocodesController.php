<?php

namespace app\controllers;

use app\models\Promocodes;
use app\models\PromocodesSearch;
use app\models\TariffPromocode;
use app\models\UsedPromocodes;
use app\models\user\User;
use app\models\UsersPromocode;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * PromocodesController implements the CRUD actions for Promocodes model.
 */
class PromocodesController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'delete', 'status', 'view'],
                        'allow' => User::checkAccess(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['list', 'use-code', 'cancel-code'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'use-code'],
                ],
            ],
        ];
    }

    /**
     * Lists all Promocodes models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PromocodesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Promocodes model.
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
     * Creates a new Promocodes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Promocodes();

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
     * Updates an existing Promocodes model.
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
     * Deletes an existing Promocodes model.
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
     * Finds the Promocodes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Promocodes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Promocodes::findOne(['id' => $id])) !== null) {
            $tariffList = TariffPromocode::find()->where(['promocode_id' => $model->id])->all();
            $userPromocode = UsersPromocode::find()->where(['promocode_id' => $model->id])->all();
            if (!empty($tariffList)) {
                $model->tariffs = ArrayHelper::map($tariffList, 'tariff_id', 'tariff_id');
            }
            if (!empty($userPromocode)) {
                $model->users = ArrayHelper::map($userPromocode, 'user_id', 'user_id');
            }
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUseCode()
    {
        if (Yii::$app->request->isAjax && $code = Yii::$app->request->post('code')) {
            $usedCodes = UsedPromocodes::find()->where(['promocode' => $code, 'user_id' => Yii::$app->user->identity->getId()])->one();
            $usedCodeCounts = UsedPromocodes::find()->where(['promocode' => $code])->count();
            $promoCode = Promocodes::find()->where(['promocode' => $code, 'status' => \app\models\Tariff::ACTIVE])->one();
            if (empty($usedCodes) && !empty($promoCode)) {
                if ($promoCode->user_limit < $usedCodeCounts) {
                    return json_encode(['result' => 'error', 'error' => 'Промокод уже использован']);
                }
                $usedCode = new UsedPromocodes();
                $usedCode->user_id = Yii::$app->user->identity->getId();
                $usedCode->promocode = $code;
                $usedCode->date = date("Y-m-d");
                if ($usedCode->save()) {
                    return json_encode(['result' => 'Промокод принят']);
                }
            }
        }
        return json_encode(['result' => 'error', 'error' => 'Промокод не найден']);
    }

    public function actionCancelCode()
    {
        if (Yii::$app->request->isAjax && $code = Yii::$app->request->post('code')) {
            $usedCodes = UsedPromocodes::find()->where(['promocode' => $code, 'user_id' => Yii::$app->user->identity->getId()])->one();
            if (!empty($usedCodes)) {
                $usedCodes->delete();
                return json_encode(['result' => 'Промокод отменен']);
            }
        }

    }
}
