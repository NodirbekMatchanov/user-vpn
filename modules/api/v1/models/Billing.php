<?php

namespace app\modules\api\v1\models;

use app\components\DateFormat;
use app\models\Accs;
use app\models\Mailer;
use app\models\MailHistory;
use app\models\Payments;
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

    const MONTH_1 = 'VPN_MAX_1MO_CONSUMABLE';
    const MONTH_6 = 'VPN_MAX_6MO_CONSUMABLE';
    const MONTH_12 = 'VPN_MAX_12MO_CONSUMABLE';
    public $testEnvironment = false;
    public $url = 'https://buy.itunes.apple.com/';
    public $testUrl = 'https://sandbox.itunes.apple.com/';

    public $receiptData;
    public $account_token = "";
    public $password = 'd004a1de361b4bc7994656c3426ba426';

//    public function rules()
//    {
//        return [
//            [['receipt-data'], 'required'],
//            [['password'], 'string', 'max' => 255],
//        ];
//    }

    public function send($method = "GET", $data = null)
    {
        $client = new Client();

        if ($method == 'GET') {
            $params = [
                'query' => $data
            ];
        } else {
            $params = [
                'body' => json_encode($data)
            ];
        }

        $response = $client->request($method, ($this->testEnvironment ? $this->testUrl : $this->url) . 'verifyReceipt', $params);
        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody());
            if (empty($data->receipt)) return false;
            $receiptApple = new ReceiptApple();
            $receiptData = (array)$data->receipt;
            $receiptData['status'] = $data->status;
            $receiptData['environment'] = $data->environment;
            $receiptApple->load($receiptData, '');

            if ($receiptApple->save()) {
                //in_app
                if (!empty($receiptData['in_app'])) {
                    foreach ($receiptData['in_app'] as $item) {

                        if (!InApp::find()->where(['transaction_id' => $item->transaction_id])->one()) {
                            $inApp = new InApp();
                            $inApp->load((array)$item, '');
                            $inApp->receipt_apple_id = $receiptApple->id;
                            if ($inApp->save()) {

                                $untildate = 0;
                                switch ($item->product_id) {
                                    case self::MONTH_1: $untildate = (3600*24)*30;
                                    break;
                                    case self::MONTH_6: $untildate = (3600*24)*180;
                                    break;
                                    case self::MONTH_12: $untildate = (3600*24)*365;
                                    break;
                                }

                                if ($untildate) {
                                    $userId = AppAccountToken::find()->where(['account_token' => $this->account_token])->one()->user_id ?? 0;
                                    if ($userId) {
                                        $user = Accs::find()->where(['user_id' => $userId])->one();
                                        $user->untildate = $user->untildate < time() ? time() +  $untildate: $user->untildate + $untildate;
                                        $user->status = VpnUserSettings::$statuses['ACTIVE'];
                                        $user->save();

                                        $payment = new Payments();
                                        $payment->app_transaction_id = $item->transaction_id;
                                        $payment->user_id = $userId;
                                        $payment->tariff = $item->product_id;
                                        $payment->status = 2;
                                        $payment->amount = 0;
                                        $payment->type = 'app';
                                        $payment->save();

                                        $mailer = new Mailer();
                                        $mailer->sendPaymentMessage($user, $untildate, date("d.m.Y", $user->untildate));

                                    }
                                }

                                return $data;

                            } else {
                                return $inApp->errors;
                            }
                        }

                    }

                }

                // latest_receipt_info
                if (!empty($receiptData['latest_receipt_info'])) {
                    foreach ($receiptData['latest_receipt_info'] as $item) {
                        $latest_receipt_info = new LatestReceiptInfo();
                        $latest_receipt_info->load((array)$item, '');
                        $latest_receipt_info->receipt_apple_id = $receiptApple->id;
                        if ($latest_receipt_info->save()) {
                            return $data;
                        } else {
                            return $latest_receipt_info->errors;
                        }
                    }
                }
            } else {
                return $receiptApple->errors;
            }

            return $data;
        }
        return ['error'];
    }

    public function generateToken($email)
    {
        $user = User::find()->where(['email' => $email])->one();
        $uuid = self::guidv4();
        if (!empty($user)) {
            $uuids = AppAccountToken::find()->where(['user_id' => $user->id])->one();
            if (empty($uuids)) {
                $uuids = new  AppAccountToken();
                $uuids->user_id = $user->id;
                $uuids->account_token = $uuid;
                $uuids->save();
            }
            return $uuids;
        }
        return ['Пользователь не найдено'];
    }

    public static function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}
