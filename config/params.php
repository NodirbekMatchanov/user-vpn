<?php
Yii::setAlias('@console', realpath(dirname(__FILE__).'/../'));
return [
    'adminEmail' => 'welcome@vpnmax.org',
    'senderEmail' => 'welcome@vpnmax.org',
    'senderName' => 'Vpn Max',
    'iosCertPath' => implode(DIRECTORY_SEPARATOR, [
        dirname(__FILE__),
        'ios_token',
        'VPN_MAX_PUSH.p12'

    ]),
];
