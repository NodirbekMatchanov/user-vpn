<?php

namespace app\modules\api\v1\models;

use app\components\DateFormat;
use app\models\Accs;
use app\models\MailHistory;
use app\models\user\Profile;
use app\models\user\LoginForm;
use http\Message;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\modules\api\v1\models\VpnUserSettings;
use dektrium\user\models\User;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;

class Billing extends Model
{

    public $testEnvironment = false;
    public $url = 'https://sandbox.itunes.apple.com/';
    public $testUrl = 'https://sandbox.itunes.apple.com/';

    public $receiptData;
    public $password = 'd004a1de361b4bc7994656c3426ba426';

//    public function rules()
//    {
//        return [
//            [['receipt-data'], 'required'],
//            [['password'], 'string', 'max' => 255],
//        ];
//    }

    public  function send($method = "GET", $data = null)
    {
        $client = new Client();

        if($method == 'GET'){
            $params =  [
                'query' => $data
            ];
        } else {
          $params =  [
                'body' => json_encode($data)
            ];
        }

        $response = $client->request($method,($this->testEnvironment ? $this->testUrl : $this->url).'verifyReceipt' , $params);
        if($response->getStatusCode() == 200){
            $data = json_decode($response->getBody());

            $receiptApple = new ReceiptApple();
            $receiptData = (array)$data->receipt;
            $receiptData['status'] = $data->status;
            $receiptData['environment'] = $data->environment;
            $receiptApple->load($receiptData,'');

            if($receiptApple->save()){
                //in_app
                if(!empty($receiptData['in_app'])){
                    foreach ($receiptData['in_app'] as $item) {
                        $inApp = new InApp();
                        $inApp->load((array)$item,'');
                        $inApp->receipt_apple_id = $receiptApple->id;
                        if($inApp->save()){
                            if(!empty($item->expires_date_ms)) {

                            }
                            return  $data;
                        } else {
                            return $inApp->errors;
                        }
                    }
                }

                // latest_receipt_info
                if(!empty($receiptData['$latest_receipt_info'])){
                    foreach ($receiptData['$latest_receipt_info'] as $item) {
                        $latest_receipt_info = new LatestReceiptInfo();
                        $latest_receipt_info->load((array)$item,'');
                        $latest_receipt_info->receipt_apple_id = $receiptApple->id;
                        if($latest_receipt_info->save()){
                            return  $data;
                        } else {
                            return $latest_receipt_info->errors;
                        }
                    }
                }
            }
            else {
                return $receiptApple->errors;
            }

            return $data;
        }
        return ['error'];
    }


}
