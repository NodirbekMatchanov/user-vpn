<?php
namespace app\controllers;

use app\helpers\PushNotification;
use app\helpers\ios\PushNotification as IosPushNotification;
use app\helpers\PushMessage;
use app\models\PushTestForm;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Request;
use yii\base\Exception;

class PushTestController extends Controller 
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (\Yii::$app->user->isGuest) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;

        $model = new PushTestForm();

        $fcm_result = false;
        $ios_result = false;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $message = new PushMessage();
            $message->setTitle($model->title);
            $message->setMessage($model->body);

            if ($model->fcm_token) {
               $fcm = new PushNotification();
               $response = $fcm->send([$model->fcm_token], $message);
               if (isset($response[$model->fcm_token])) {
                   $fcm_result = $response[$model->fcm_token];
               }
            }

            if ($model->ios_token) {
                try {
                    $ios = IosPushNotification::getInstance(
                        \Yii::$app->params['iosCertPath'], false
                    );
                    $response = $ios->send($model->ios_token, $message);
                    if (isset($response[$model->ios_token])) {
                       $ios_result = $response[$model->ios_token];
                    }
                    $ios->close();
                } catch(\Exception $e) {
                    $ios_result = [ false, $e->getMessage() ];
                }
            }
        }
        
    	return $this->render('index', [ 
            'model'      => $model, 
            'fcm_result' => $fcm_result,
            'ios_result' => $ios_result,
        ]);
    }
}
