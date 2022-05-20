<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\Promocodes;
use app\models\Support;
use app\models\UsedPromocodes;
use app\models\VpnIps;
use app\modules\api\v1\models\Users;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

/**
 * Class PatientController
 */
class PromocodeController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['check'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    /* метод  возвращает  список справочника */
    public function actionCheck()
    {
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $promocodes = UsedPromocodes::ValidationPromoCode($request['promocode']);
        return $this->apiItem(json_decode($promocodes));
    }


}
