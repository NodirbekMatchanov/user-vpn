<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/console.php';
$application = new yii\console\Application($config);

class UserUsageStatController
{
    public function actionUpdateUsageUser(){
        \app\models\VpnIps::updateUsageState();
    }
}
 $run = new UserUsageStatController();
$run->actionUpdateUsageUser();