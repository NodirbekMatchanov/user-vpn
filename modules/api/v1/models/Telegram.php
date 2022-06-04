<?php

namespace app\modules\api\v1\models;

use aki\telegram\base\Command;
use app\components\DateFormat;
use app\models\Accs;
use app\models\Mailer;
use app\models\MailHistory;
use app\models\Payments;
use app\models\user\Profile;
use app\models\user\LoginForm;
use http\Message;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\modules\api\v1\models\VpnUserSettings;
use dektrium\user\models\User;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;

class Telegram extends Model
{

    public $data;
    public $message;
    public $chatId;
    public $request;

    public function handler()
    {

        if (!empty($this->request['callback_query']['data']) && $data = $this->request['callback_query']['data']) {
            $this->chatId = $this->request['callback_query']['message']['chat']['id'] ?? 0;
            $this->message = $this->request['callback_query'] ?? [];
//            $this->deletemessage();
            $this->{$data}();
        }


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
                            ['text' => "Подписаться", 'callback_data' => "subscribe"],
                        ],
                        [
                            ['text' => "Доступные локации", 'callback_data' => "location"]
                        ],
                        [
                            ['text' => "🤔 Узнать о VPN", 'callback_data' => "aboutVpn"],
                            ['text' => "❓ Помощь", 'callback_data' => "location"],
                        ],
                        [
                            ['text' => "🎁 Посоветовать друзьям", 'callback_data' => "location"],
                            ['text' => "💰 Партнерство", 'callback_data' => "location"],
                        ],
                    ]
                ]),
            ]);
        });

    }

    public function deletemessage()
    {
        Yii::$app->telegram->deleteMessage([
            'chat_id' => $this->chatId,
            'message_id' => $this->message['id']
        ]);

    }

    public function start()
    {
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->chatId,
            "text" => " VPN_MAX откроет доступ к свободному и безопасному интернету с любого устройства
                
    📱 Доступ к Instagram, TikTok, Facebook, Twitter и другим недоступным ресурсам
    
    🚀️ Высокая скорость (гигабитный канал и безлимитный трафик) и неограниченное число устройств
    
    ⚡️ Оперативная и дружелюбная поддержка. Поможем настроить VPN даже на роутере
    
    💳 Оплата российскими картами (включая МИР), украинскими картами, картами зарубежных банков и даже криптовалютой
    
    🌏 Локации по всему миру, включая Украину и Казахстан
    
    🎬 Доступ к сервисам, недоступным в вашей стране по выгодным ценам (Netflix, Spotify, Apple)",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    'inline_keyboard' => [
                        [
                            ['text' => "Подписаться", 'callback_data' => "subscribe"],
                        ],
                        [
                            ['text' => "Доступные локации", 'callback_data' => "location"]
                        ],
                        [
                            ['text' => "🤔 Узнать о VPN", 'callback_data' => "aboutVpn"],
                            ['text' => "❓ Помощь", 'callback_data' => "location"],
                        ],
                        [
                            ['text' => "🎁 Посоветовать друзьям", 'callback_data' => "location"],
                            ['text' => "💰 Партнерство", 'callback_data' => "location"],
                        ],
                    ]
                ]
            ]),
        ]);
    }

    public function subscribe()
    {
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->chatId,
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
                        ['text' => "Bitcoin, ETH, Qiwi, ЮMoney", 'callback_data' => "bitcount_payment"],
                    ],
                    [
                        ['text' => "Назад", 'callback_data' => "start"],
                    ]
                ]
            ]),
        ]);
    }

    public function location()
    {
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->chatId,
            "text" =>
"📍 Доступные локации
🇰🇿 Караганда (Казахстан)
🇭🇰 Гонконг (Гонконг)
🇩🇪 Франкфурт (Германия)
🇺🇦 Киев (Украина)
🇸🇪 Стокгольм (Швеция)
🇨🇿 Прага (Чехия)
🇳🇱 Амстердам (Нидерланды)
🇹🇷 Стамбул (Турция)
🇺🇸 Нью-Йорк (США)
🇱🇹 Вильнюс (Литва)",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "Назад", 'callback_data' => "start"],
                    ]
                ]
            ]),
        ]);
    }

    public function aboutVpn()
    {
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->chatId,
            "text" =>
"Зачем нужен VPN MAX?

🔒 Скроет ваши действия в сети от интернет-провайдеров и владельцев сайтов

👀 Откроет доступ к свободному интернету и социальным сетям (TikTok, Instagram, Facebook)

🎬 Поможет получить доступ к сервисам, недоступным в вашей стране по выгодным ценам (Netflix, Spotify, Apple)

🕵️‍ Изменяйте свой IP-адрес и усиливайте конфиденциальность в интернете

Узнать больше можно в нашей базе знаний (https://support.fckvpn.com/). Если останутся вопросы, мы на связи – пишите прямо сюда, поможем!",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "Назад", 'callback_data' => "start"],
                    ]
                ]
            ]),
        ]);
    }

    public function bank_card_ru()
    {
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->chatId,
            "text" => "bank_card_ru",
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [
//                        ['text' => "🇷🇺 Банковской картой (Россия)", 'callback_data' => "bank_card_ru"],
//                    ],
//                    [
//                        ['text' => "Банковской картой (вне России)", 'callback_data' => "bank_card_out_ru"],
//                    ],
//                    [
//                        ['text' => "Bitcoin, ETH, Qiwi, ЮMoney", 'callback_data' => "bank_card_out_ru"],
//                    ],
//                    [
//                        ['text' => "Назад", 'callback_data' => "start"],
//                    ]
//                ]
//            ]),
        ]);
    }

    public function bank_card_out_ru()
    {
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->chatId,
            "text" => "bank_card_out_ru",
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [
//                        ['text' => "🇷🇺 Банковской картой (Россия)", 'callback_data' => "bank_card_ru"],
//                    ],
//                    [
//                        ['text' => "Банковской картой (вне России)", 'callback_data' => "bank_card_out_ru"],
//                    ],
//                    [
//                        ['text' => "Bitcoin, ETH, Qiwi, ЮMoney", 'callback_data' => "bank_card_out_ru"],
//                    ],
//                    [
//                        ['text' => "Назад", 'callback_data' => "start"],
//                    ]
//                ]
//            ]),
        ]);
    }

    public function bitcount_payment()
    {
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->chatId,
            "text" => "bitcount_payment",
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [
//                        ['text' => "🇷🇺 Банковской картой (Россия)", 'callback_data' => "bank_card_ru"],
//                    ],
//                    [
//                        ['text' => "Банковской картой (вне России)", 'callback_data' => "bank_card_out_ru"],
//                    ],
//                    [
//                        ['text' => "Bitcoin, ETH, Qiwi, ЮMoney", 'callback_data' => "bitcount_payment"],
//                    ],
//                    [
//                        ['text' => "Назад", 'callback_data' => "start"],
//                    ]
//                ]
//            ]),
        ]);
    }

}
