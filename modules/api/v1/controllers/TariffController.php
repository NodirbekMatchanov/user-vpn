<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\Tariff;
use app\models\VpnIps;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

/**
 * Class PatientController
 */
class TariffController extends Controller
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

    /* метод  возвращает  список tariff */
    public function actionIndex()
    {
        $vpnIps = Tariff::getTariffs();
        return $this->apiItem($vpnIps);
    }


}
