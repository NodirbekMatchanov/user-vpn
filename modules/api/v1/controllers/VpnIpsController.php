<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\VpnIps;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

/**
 * Class PatientController
 */
class VpnIpsController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['index'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    /* метод  возвращает  список серверов */
    public function actionIndex()
    {
        $vpnIps = VpnIps::getVpnServerList();
        return $this->apiItem($vpnIps);
    }


}
