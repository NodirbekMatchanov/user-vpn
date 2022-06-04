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
        Yii::$app->telegram->setWebhook(['url' => "https://www.vpn-max.com/api/telegram"]);

    }

    public function actionIndex()
    {
        Command::run("/start", function ($telegram) {

            $result = $telegram->sendMessage([
                'chat_id' => $telegram->input->message->chat->id,
                "text" => " VPN_MAX откроет доступ к свободному и безопасному интернету с любого устройства
    📱 Доступ к Instagram, TikTok, Facebook, Twitter и другим недоступным ресурсам
    🚀️ Высокая скорость (гигабитный канал и безлимитный трафик) и неограниченное число устройств
    ⚡️ Оперативная и дружелюбная поддержка. Поможем настроить VPN даже на роутере
    💳 Оплата российскими картами (включая МИР), украинскими картами, картами зарубежных банков и даже криптовалютой
    🌏 Локации по всему миру, включая Украину и Казахстан
    🎬 Доступ к сервисам, недоступным в вашей стране по выгодным ценам (Netflix, Spotify, Apple)",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "Подписаться", 'callback_data' => "subscribe"]
                        ]
                    ]
                ]),
            ]);
        });
        $handler = new Telegram();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $handler->request = $request;
        $handler->handler();
    }


}
