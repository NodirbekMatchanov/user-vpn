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
            'except' => ['check','history'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    /* метод  проверяет валидность промокода */
    public function actionCheck()
    {
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $promocodes = UsedPromocodes::ValidationPromoCode($request['promocode'],$request['email'] ?? false);
        return $this->apiItem(json_decode($promocodes));
    }

    /* метод  возвращает  историю промокодов */
    public function actionHistory()
    {
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $promocodes = UsedPromocodes::getHistory($request);
        return $this->apiItem($promocodes);
    }


}
