<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\Accs;
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
            'except' => ['check','history','get-stat','use'],
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

    /* метод  возвращает  инфо по промокоду */
    public function actionGetStat()
    {
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $promocodes = UsedPromocodes::getStatByPromocode($request);
        return $this->apiItem($promocodes);
    }

    /* метод промокоду */
    public function actionUse()
    {
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if(empty($request['promocode']) || $request['email']) {
            return $this->apiItem(['result' => 'error','error' => 'promocode and email require field']);
        }
        $valid = UsedPromocodes::ValidationPromoCode($request['promocode'],$request['email']);
        $result = json_decode($valid,true);
        if($result['result'] != 'error') {
            $user = Accs::find()->where(['email' => $request['email']])->one();
            $promocodes = Accs::setPromoShareCount($request['promocode'],$user,null,'use');
        } else {
            $this->apiItem($result);
        }
        return $this->apiItem(['result' => 'used']);
    }


}
