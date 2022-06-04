<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\VpnIps;
use app\modules\api\v1\models\Billing;
use app\modules\api\v1\models\Telegram;
use app\modules\api\v1\models\Users;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use aki\telegram\base\Command;
use yii\helpers\JSON;
/**
 * Class PatientController
 */
class TelegramController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['index', 'run'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    public function actionRun()
    {
        Yii::$app->telegram->setWebhook(['url' => "http://www.vpn-max.com/api/telegram"]);

    }

    public function actionIndex()
    {
        $handler = new Telegram();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $handler->request = $request;
        $handler->handler();
    }


}
