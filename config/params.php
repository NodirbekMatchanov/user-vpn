<?php
Yii::setAlias('@console', realpath(dirname(__FILE__).'/../'));
return [
    'adminEmail' => 'welcome@vpnmax.org',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'iosCertPath' => implode(DIRECTORY_SEPARATOR, [
        dirname(__FILE__),
        'ios_token',
        'VPN_MAX_PUSH.p12'

    ]),
];
