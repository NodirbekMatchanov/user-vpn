<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\VpnIps;
use app\modules\api\v1\models\Billing;
use app\modules\api\v1\models\Users;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use aki\telegram\base\Command;

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
            'except' => ['index','run'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    public function actionRun(){
        Yii::$app->telegram->setWebhook(['url' => "https://www.vpn-max.com/api/telegram"]);

    }

    public function actionIndex()
    {
        Command::run("/start", function($telegram){
            $result = $telegram->sendMessage([
                'chat_id' => $telegram->input->message->chat->id,
                "text" => "hello"
            ]);
        });
        Yii::$app->telegram->sendMessage([
            'chat_id' => 411213390,
            'text' => 'this is test',
            'reply_markup' => json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"refresh",'callback_data'=> time()]
                    ]
                ]
            ]),
        ]);
        $res = Yii::$app->telegram->sendMessage([
            'chat_id' => 411213390,
            'text' => 'hello world!!'
        ]);
    }

}
