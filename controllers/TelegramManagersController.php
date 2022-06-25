<?php

namespace app\controllers;

use app\models\TelegramManagers;
use app\models\TelegramManagersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TelegramManagersController implements the CRUD actions for TelegramManagers model.
 */
class TelegramManagersController extends Controller
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
     * Lists all TelegramManagers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TelegramManagersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TelegramManagers model.
     * @param int $chat_id Chat ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($chat_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($chat_id),
        ]);
    }

    /**
     * Creates a new TelegramManagers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TelegramManagers();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'chat_id' => $model->chat_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TelegramManagers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $chat_id Chat ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($chat_id)
    {
        $model = $this->findModel($chat_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'chat_id' => $model->chat_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TelegramManagers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $chat_id Chat ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($chat_id)
    {
        $this->findModel($chat_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TelegramManagers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $chat_id Chat ID
     * @return TelegramManagers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($chat_id)
    {
        if (($model = TelegramManagers::findOne(['chat_id' => $chat_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
