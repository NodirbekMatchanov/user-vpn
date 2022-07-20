<?php

namespace app\controllers;

use app\models\Accs;
use app\models\User;
use app\models\user\Profile;
use app\models\UserEventsSearch;
use app\models\UserTokensSearch;
use app\models\VpnUserSettings;
use app\models\VpnUserSettingsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * VpnUserSettingsController implements the CRUD actions for VpnUserSettings model.
 */
class VpnUserSettingsController extends Controller
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
                        'actions' => ['index','create', 'update', 'view','delete'],
                        'allow' => Yii::$app->user->identity->checkAccess(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['my-vpn'],
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
        if(Yii::$app->user->isGuest){
            throw new ForbiddenHttpException('нет доступа');
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Lists all VpnUserSettings models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VpnUserSettingsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all VpnUserSettings models.
     *
     * @return string
     */
    public function actionMyVpn()
    {
        $searchModel = new VpnUserSettingsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        return $this->render('user/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VpnUserSettings model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new UserEventsSearch();
        $dataProviderEvents = $searchModel->searchByUserId($this->request->queryParams, $model->user_id);
        $searchModelTokens = new UserTokensSearch();
        $dataProviderTokens = $searchModelTokens->search($this->request->queryParams,$model->user_id);

        return $this->render('view', [
            'model' => $model,
            'dataProviderEvents' => $dataProviderEvents,
            'dataProviderTokens' => $dataProviderTokens,
            'searchModel' => $searchModel,
            'searchModelTokens' => $searchModelTokens,
        ]);
    }

    /**
     * Creates a new VpnUserSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new VpnUserSettings();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect('/vpn-user-settings/index');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VpnUserSettings model.
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
     * Deletes an existing VpnUserSettings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $accs = Accs::find()->where(['vpnid' => $id])->one();
        if(!empty($accs)){
            $accs->delete();
            $user = User::find()->where(['id' => $accs->user_id])->one();
            if(!empty($user)){
                $user->delete();
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the VpnUserSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return VpnUserSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VpnUserSettings::findOne(['id' => $id])) !== null) {
            $accs = Accs::find()->where(['vpnid' => $model->id])->one();
            if(!empty($accs)){
                $model->datecreate = $accs->datecreate;
                $model->untildate = date("Y-m-d h:i",$accs->untildate);
                $model->status = $accs->status;
                $model->email = $accs->email;
                $model->pass = $accs->pass;
                $model->user_id = $accs->user_id;
                $model->sccId = $accs->id;
                $model->promocode = $accs->promocode;
                $model->test_user = $accs->test_user;
                $model->tariff = $accs->tariff;
                $model->background_work = $accs->background_work;
                $model->comment = $accs->comment;
                $profile = Profile::find()->where(['user_id' => $accs->user_id])->one();
                if(!empty($profile)){
                    $model->phone = $profile->phone;
                }
            }
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
