<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\Support;
use app\models\VpnIps;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

/**
 * Class PatientController
 */
class SupportController extends Controller
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

    /* метод  возвращает  список справочника */
    public function actionIndex()
    {
        $vpnIps = Support::find()->where(['is_active' => 1])->all();
        return $this->apiItem($vpnIps);
    }


}
