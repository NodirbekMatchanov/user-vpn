<?php
namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use \app\models\UserGroupRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;

        $auth = Yii::$app->authManager;

        // добавляем роль "user"
        $user = $auth->createRole('user');
        $auth->add($user);

        // добавляем роль "admin"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);

        $this->actionAddAdmin();
    }

    public function actionAddAdmin() {
        $model = User::find()->where(['username' => 'admin'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'admin';
            $user->email = 'admin@mail.ru';
            $user->created_at = time();
            $user->updated_at = time();
            $user->setPassword('admin');
            $user->generateAuthKey();
            if ($user->save()) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('admin');
                $auth->assign($role, $user->id);
            }
        }
    }
}