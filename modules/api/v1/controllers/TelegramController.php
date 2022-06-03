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
        $request = json_encode($_REQUEST);
        Yii::$app->telegram->sendMessage([
            'chat_id' => 411213390,
            'text' => $request,
        ]);

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

        Command::run("/subscribe", function ($telegram) {
            $result = $telegram->sendMessage([
                'chat_id' => $telegram->input->message->chat->id,
                "text" => "💳 Выберите способ оплаты.
                            Не знаете, что выбрать? Задайте вопрос прямо в этом чате, мы поможем!",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "🇷🇺 Банковской картой (Россия)", 'callback_data' => "bank_card_ru"],
                        ],
                        [
                            ['text' => "Банковской картой (вне России)", 'callback_data' => "bank_card_out_ru"],
                        ],
                        [
                            ['text' => "Bitcoin, ETH, Qiwi, ЮMoney", 'callback_data' => "bank_card_out_ru"],
                        ],
                        [
                            ['text' => "Назад", 'callback_data' => "start"],
                        ]
                    ]
                ]),
            ]);
        });

//        Yii::$app->telegram->sendMessage([
//            'chat_id' => 411213390,
//            'text' => 'this is test',
//            'reply_markup' => json_encode([
//                'inline_keyboard'=>[
//                    [
//                        ['text'=>"refresh",'callback_data'=> time()]
//                    ]
//                ]
//            ]),
//        ]);
    }


}
