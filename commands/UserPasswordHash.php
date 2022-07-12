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
        $users = \app\models\User::find()->all();
        foreach ($users as $user) {
            $accs = \app\models\Accs::find()->where(['user_id' => $user->id])->one();
            if(!empty($accs)) {
                $passwordHash = Yii::$app->security->generatePasswordHash($accs->pass);
                $accs->pass = $passwordHash;
                $accs->save();
            }
        }
    }
}

$run = new UserPasswordHash();
$run->actionUpdatePassword();