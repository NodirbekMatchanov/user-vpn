<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/console.php';
$application = new yii\console\Application($config);

class UserPasswordHash
{
    public function actionUpdatePassword()
    {
        echo Yii::$app->security->generatePasswordHash('1234567');
        echo Yii::$app->security->validatePassword('1234567','$2y$13$6bV8w8WlNawHTJ5ym1P64eZYqfaOil/7o9dicH6Eu8P4aQHSn5e2q');
        echo Yii::$app->security->validatePassword('1234567','$2y$13$WrhHs63FCRiuBpARDHCDC.J6pvN3riF5hyLZRCg.sxYPNvnvfneO2');
            die;
        $users = \app\models\User::find()->all();
        foreach ($users as $user) {
            $accs = \app\models\Accs::find()->where(['user_id' => $user->id])->one();
            if(!empty($accs)) {
                $passwordHash = Yii::$app->security->generatePasswordHash($accs->pass);
                echo $passwordHash."\n";
                $accs->pass = $passwordHash;
                $accs->save();
            }
        }
    }

    public function actionDeleteNoActive() {
        $accs = \app\models\Accs::find()->where(['status' => \app\models\VpnUserSettings::$statuses['NOACTIVE']])
            ->andWhere(['<','datecreate',strtotime(date("2022-07-20"))])->all();
        foreach ($accs as $acc) {
            $redcheck = \app\models\VpnUserSettings::find()->where(['id' => $acc->vpnid])->one();
            if(!empty($redcheck)) {
                $redcheck->delete();
            }
            $user = \app\models\User::find()->where(['id' => $acc->user_id])->one();
            if(!empty($user)) {
                $user->delete();
            }
        }
    }
}

$run = new UserPasswordHash();
$run->actionDeleteNoActive();