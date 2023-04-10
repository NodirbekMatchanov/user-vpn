<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db2 = require __DIR__ . '/db2.php';

$config = [
    'id' => 'basic',
    'name' => 'VPN MAX',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'multiLanguage'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'ru',

    'components' => [
        'apns' => [
            'class' => 'bryglen\apnsgcm\Apns',
            'environment' => \bryglen\apnsgcm\Apns::ENVIRONMENT_PRODUCTION,
            'pemFile' => __DIR__.'/ios_token/VPN_MAX_PUSH.pem',
            // 'retryTimes' => 3,
            'options' => [
                'sendRetryTimes' => 5
            ]
        ],
//        'request' => [
//            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
//            'cookieValidationKey' => 'b1I97EHuHiX4cVlK6Wp96pRVr-1cLf5O',
//        ],

        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '5599707945:AAGpyC42hsbNmDyce8le1aNFbXtDiqBj0Ko',
        ],
        'push' => [
            'class' => 'develandoo\notification\Push',
            'options' => [
                'returnInvalidTokens' => true //default false
            ],
            'apnsConfig' => [
                'environment' => \develandoo\notification\Push::APNS_ENVIRONMENT_PRODUCTION ,
                'pem' => __DIR__.'/ios_token/VPN_MAX_PUSH.pem',
                'passphrase' => 'VPN_MAX', //optional
            ],
            'gcmConfig' => [
                'apiAccessKey' => 'YOUR_GCM_API_KEY'
            ]
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php'
                    ],
                ],
            ],
        ],

        "request" => [
            'cookieValidationKey' => 'b1I97EHuHiX4cVlK6Wp96pRVr-1cLf5O',
            'baseUrl'=> '',
            "class" => \skeeks\yii2\multiLanguage\MultiLangRequest::class
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\user\User',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.timeweb.ru',
                'username' => 'welcome@vpn-max.com',
                'password' => 'Pt7JHXYn',
//                'username' => 'no-reply@mpclick.ru',
//                'password' => 'frisky_noreply',
//                yWK8$c=DT[/w5gp
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'db2' => $db2,

//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'rules' => [
//            ],
//        ],

        "urlManager" => [
            "class" => \skeeks\yii2\multiLanguage\MultiLangUrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/tos' => '/site/termsofservice',
            ],
        ],
        "multiLanguage" => [
            "class" => \skeeks\yii2\multiLanguage\MultiLangComponent::class,
            'langs' => ['ru', 'en'],
            'default_lang' => 'fr',         //Language to which no language settings are added.
            'lang_param_name' => 'lang',
        ]

    ],

    'modules' => [
        'user' => [
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'enableAccountDelete' => true,
            'enablePasswordRecovery' => true,
            'cost' => 12,
           'admins' => ['admin'],
            // following line will restrict access to profile, recovery, registration and settings controllers from backend
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'User' => 'app\models\user\User',
                'Profile' => 'app\models\user\Profile',
                'RegistrationForm' => 'app\models\user\RegistrationForm',
                'SettingsForm' => 'app\models\user\SettingsForm',
                'RecoveryForm' => 'app\models\user\RecoveryForm',
                'LoginForm' => 'app\models\user\LoginForm',
                'ResetPasswordEvent' => 'app\models\events\ResetPasswordEvent',
                'EventTrait' => 'app\models\traits\EventTrait',
            ],
            'mailer' => [
                'class' => 'app\models\Mailer',
                'sender' => ['welcome@vpn-max.com' => 'Сервис VPN MAX'], // or ['no-reply@myhost.com' => 'Sender name']
                'viewPath' => '@app/views/user/mail',
                'welcomeSubject' => 'Добро пожаловать в VPN MAX',
                'confirmationSubject' => 'Confirmation subject',
                'reconfirmationSubject' => 'Email change subject',
                'recoverySubject' => 'Восстановление пароля',
            ],
            'controllerMap' => [
                'security' => 'app\controllers\user\SecurityController',
                'registration' => 'app\controllers\user\RegistrationController',
                'recovery' => 'app\controllers\user\RecoveryController',
                'settings' => 'app\controllers\user\SettingsController',
                'elfinder' => [
                    'class' => 'mihaildev\elfinder\PathController',
                    'access' => ['?'],
                    'root' => [
                        'path' => 'upload/global',
                        'name' => 'Global'
                    ],
                ]
            ],
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
//        'api' => [
//            'class' => 'app\modules\api\v1\api',
//        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['?','@'],
            'root' => [
                'baseUrl'=>'@web/web/',
                'basePath'=>'@webroot',
                'path' => '/upload/',
                'name' => ''
            ],
        ]
    ],
    'on beforeRequest' => function ($event) {
        Yii::$app->language = Yii::$app->session->get('language', 'ru');
    },
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
