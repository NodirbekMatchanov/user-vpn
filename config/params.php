<?php
Yii::setAlias('@console', realpath(dirname(__FILE__).'/../'));
return [
    'adminEmail' => 'welcome@vpn-max.com',
    'senderEmail' => 'welcome@vpn-max.com',
    'senderName' => 'Vpn Max',
    'iosCertPath' => implode(DIRECTORY_SEPARATOR, [
        __DIR__,
        'ios_token',
        'VPN_MAX_PUSH.pem'

    ]),
];
