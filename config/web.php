<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db2 = require __DIR__ . '/db2.php';

$config = [
    'id' => 'basic',
    'name' => 'VPN MAX',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'ru',

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'b1I97EHuHiX4cVlK6Wp96pRVr-1cLf5O',
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
                'username' => 'welcome@vpnmax.org',
                'password' => 'FZ2PTXVz',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],


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
                'sender' => ['welcome@vpnmax.org' => 'Сервис VPN MAX'], // or ['no-reply@myhost.com' => 'Sender name']
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
            ],
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        'api' => [
            'class' => 'app\modules\api\v1\api',
        ],
    ],
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
