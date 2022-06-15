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
            'except' => ['index', 'run','create-user', 'get-user'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    public function actionRun()
    {
        Yii::$app->telegram->setWebhook(['url' => "https://www.vpn-max.com/web/js/test/bot.php"]);

    }

    public function actionIndex()
    {
        $handler = new Telegram();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $handler->request = $request;
        $handler->handler();
    }

    public function actionCreateUser()
    {
        $user = new Users();
        $request = Yii::$app->request->post();
        if ($user->load($request,"") && $userData = $user->createBaseUser()) {
            if (is_array($userData)){
                return $this->apiCreated($userData);
            }
            return $this->apiCreated($user);
        }
        return $this->apiError($user->errors);
    }

    public function actionGetUser()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if ($userData = $user->getUserDataByChatId($request['chatId'])) {
            if (is_array($userData)) {
                return $this->apiCreated($userData);
            }
            return $this->apiCreated($user);
        }
        return $this->apiError($user->errors);
    }


}
