<?php

namespace app\modules\api\v1\controllers;

use app\components\Controller;
use app\modules\api\v1\models\Users;
use yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

/**
 * Class PatientController
 */
class UserVpnController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['create','activate','recover','login','get-verify-code','check-login','push','delete'],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        return $behaviors;
    }

    /** create user
     * @return array
     */
    public function actionCreate()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if ($user->load($request,"") && $user->validate() && $user->createUser()) {
            return $this->apiCreated($user);
        }
        return $this->apiError($user->errors);
    }

    /** active user
     * @return array
     */
    public function actionActivate()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if (isset($request['email']) && isset($request['verifyCode'])) {
            return $this->apiItem($user->checkVerifyCode($request['email'],$request['verifyCode']));
        }
        return $this->apiError($user->errors);
    }

    /** Recover user
     * @return array
     */
    public function actionRecover()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if (isset($request['email']) && $user->load($request,"") && $res = $user->recoverUser($request['email'])) {
            return $this->apiItem($res);
        }
        return $this->apiError($user->errors);
    }

    /** push user
     * @return array
     */
    public function actionPush()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if ($user->load($request,"") && $res = $user->push()) {
            return $this->apiItem($res);
        }
        return $this->apiError($user->errors);
    }

    /** Recover user
     * @return array
     */
    public function actionGetVerifyCode()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if (isset($request['email']) && $user->load($request,"") && $res = $user->getCode()) {
            return $this->apiItem($res);
        }
        return $this->apiError($user->errors);
    }

    /** login user
     * @return array
     */
    public function actionLogin()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if ( $user->load($request,"")  && $userData = $user->login()) {
            return $this->apiItem($userData);
        }
        return $this->apiError($user->errors);
    }

    /** login user
     * @return array
     */
    public function actionDelete()
    {
        $user = new Users();
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        if ( $user->load($request,"")  && $userData = $user->deleteUser()) {
            return $this->apiItem($userData);
        }
        return $this->apiError($user->errors);
    }

    /** login user
     * @return array
     */
    public function actionCheckLogin()
    {
        $user = new Users();
        $user->vpnLogin = Yii::$app->request->get('vpnLogin');
        $user->vpnPassword = Yii::$app->request->get('vpnPassword');
        if ($userData = $user->check()) {
            return $this->apiItem($userData);
        }
        return $this->apiError($user->errors);
    }


}
