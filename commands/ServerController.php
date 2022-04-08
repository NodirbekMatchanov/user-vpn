<?php
namespace app\commands;

use app\models\User;
use app\models\VpnIps;
use Yii;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionUpdateActiveUser(){
        VpnIps::updateActiveConnection();
    }
}