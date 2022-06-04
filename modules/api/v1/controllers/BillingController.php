<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\models\VpnIps;
use app\modules\api\v1\models\Billing;
use app\modules\api\v1\models\Users;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

/**
 * Class PatientController
 */
class BillingController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['verify-receipt','verify-receipt-test','get-account-token'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    public function actionVerifyReceipt()
    {
        $billing = new Billing();
        $billing->testEnvironment = false;
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if(empty($request['receipt-data']) || empty($request['account_token'])) {
            return $this->apiError("no valid request");
        }
        $data = [
            'password' => $billing->password,
            'receipt-data' => $request['receipt-data'],
            'exclude-old-transactions' => false,
        ];
        $billing->account_token = $request['account_token'];
        $res = $billing->send("POST", $data);
        if($res) {
            return $this->apiItem($res);
        }
        return $this->apiError("not valid");
    }

    public function actionVerifyReceiptTest()
    {
        $billing = new Billing();
        $billing->testEnvironment = true;
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if(empty($request['receipt-data']) || empty($request['account_token'])) {
            return $this->apiError("no valid request");
        }
        $data = [
            'password' => $billing->password,
            'receipt-data' => $request['receipt-data'],
            'exclude-old-transactions' => false,
        ];
        $billing->account_token = $request['account_token'];
        $res = $billing->send("POST", $data);
        if($res) {
            return $this->apiItem($res);
        }
        return $this->apiError("not valid");
    }

    public function actionGetAccountToken()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $billing = new Billing();

        if(!empty($request['email'])) {
            return $this->apiItem($billing->generateToken($request['email']));
        }
        return $this->apiError("not valid");
    }


}
