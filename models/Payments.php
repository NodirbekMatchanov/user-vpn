<?php

namespace app\models;

use app\models\user\RegistrationForm;
use Yii;
use app\models\Mailer;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property string $orderId
 * @property int $user_id
 * @property string $datecreate
 * @property string $tariff
 * @property string $type
 * @property string $payer_email
 * @property float $amount
 * @property int $status
 * @property int $source
 * @property string $promocode
 * @property int $app_transaction_id
 */
class Payments extends \yii\db\ActiveRecord
{
    const PAYED = 2;
    const ERROR = 0;
    const ERROR_BALANCE = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderId', 'user_id', 'tariff', 'amount', 'status'], 'required'],
            [['user_id', 'status', 'app_transaction_id'], 'integer'],
            [['datecreate'], 'safe'],
            [['amount'], 'number'],
            [['tariff', 'source', 'payer_email', 'promocode', 'type', 'orderId'], 'string', 'max' => 50],
            [['orderId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderId' => 'Order ID',
            'user_id' => 'Пользователь',
            'datecreate' => 'Дата покупки',
            'tariff' => 'Дней',
            'amount' => 'Amount',
            'status' => 'Status',
            'promocode' => 'Промокод',
            'regDate' => 'Дата регистрации',
            'type' => 'Тип',
        ];
    }

    public function successPaymentHook()
    {
        $mailer = new Mailer();

        if (\Yii::$app->request->get('InvoiceId')) {

            $data = \Yii::$app->request->get();
            if ($order = Payments::find()->where(['orderId' => $data['InvoiceId']])->one()) {
                if ($data['Status'] == "Completed" && (int)$order->amount == (int)$data['Amount']) {
                    $order->status = Payments::PAYED;
                    $order->save();
                    if (!empty($order->payer_email) && $order->source != "telegram") {
                        $hasUser = Accs::find()->where(['email' => $order->payer_email])->one();
                        if (empty($hasUser)) {
                            $password = \Yii::$app->security->generateRandomString(8);
                            $userData = [
                                'email' => $order->payer_email,
                                'password' => $password,
                                'password_repeat' => $password,
                            ];

                            /** @var RegistrationForm $model */
                            $model = \Yii::createObject(RegistrationForm::className());

                            /*если в куки есть промокод то передаем в модель*/
                            if (isset($_COOKIE['promocode'])) {
                                $model->promocode = $_COOKIE['promocode'];
                            }

                            if ($model->load($userData, '') && $model->register()) {
                                \Yii::info('registration user');
                                $user = Accs::find()->where(['email' => $order->payer_email])->one();
                                $countDay = Tariff::getPeriod($order->tariff);
                                $time = $countDay * (3600 * 24);
                                $user->untildate = ($user->untildate < time()) ? (time() + $time) : ($user->untildate + $time);
                                $user->tariff = "Premium";
                                $user->background_work = 1;
                                $user->save(false);
                                \Yii::info('save premium tariff for user');

                                $userModel = User::findOne($user->user_id);
                                $usedPromocode = Accs::setPromoShareCount($order->promocode, $userModel);

                                $order->user_id = (int)$user->user_id;
                                $order->save(false);
                                \Yii::info('save order user_id');

                                $this->saveEvent($user->user_id, $order->amount . " руб. " . $countDay . ' дней');
                                \Yii::info('save event');
                                $mailer->sendPaymentMessage($user, $countDay, date("d.m.Y", $user->untildate));
                                \Yii::info('send email');

                            } else {
                                return $model->errors;
                            }

                        } else {
                            $countDay = Tariff::getPeriod($order->tariff);
                            $time = $countDay * (3600 * 24);
                            $hasUser->untildate = $hasUser->untildate < time() ? (time() + $time) : $hasUser->untildate + $time;
                            $hasUser->tariff = "Premium";
                            $hasUser->background_work = 1;
                            $hasUser->save(false);
                            $this->saveEvent($hasUser->user_id, $order->amount . " руб. " . Tariff::getPeriod($order->tariff) . ' дней');
                            $mailer->sendPaymentMessage($hasUser, $countDay, date("d.m.Y", $hasUser->untildate));
                            $userModel = User::findOne($hasUser->user_id);
                            $usedPromocode = Accs::setPromoShareCount($order->promocode, $userModel);

//                            $usedPromo = new UsedPromocodes();
//                            $usedPromo->status = 2;
//                            $usedPromo->user_id = $hasUser->user_id;
//                            $usedPromo->type = UsedPromocodes::PAYOUT;
//                            $usedPromo->date = date("Y-m-d");
//                            $usedPromo->save();
                        }
                    } else {
                        if ($order->source == "telegram") {
                            $user = Accs::find()->where(['chatId' => $order->payer_email])->one();
                        } else {
                            $user = Accs::find()->where(['user_id' => $order->user_id])->one();
                        }
                        $countDay = Tariff::getPeriod($order->tariff);
                        $time = $countDay * (3600 * 24);
                        $user->untildate = $user->untildate < time() ? (time() + $time) : $user->untildate + $time;
                        $user->tariff = "Premium";
                        $user->background_work = 1;
                        $user->save(false);

//                        $usedPromo = new UsedPromocodes();
//                        $usedPromo->status = 2;
//                        $usedPromo->user_id = $order->user_id;
//                        $usedPromo->type = UsedPromocodes::PAYOUT;
//                        $usedPromo->date = date("Y-m-d");
//                        $usedPromo->save();

                        if ($order->source == "telegram") {
                            $telegramUsers = TelegramUsers::find()->where(['chat_id' => $order->payer_email])->one();
                            $telegramUsers->tariff = "Premium";
                            $telegramUsers->background_work = 1;
                            $telegramUsers->save();
                            // если первый  покупка и покупка по рефералу
                            if (!empty($telegramUsers->ref) && (Payments::find()->where(['payer_email' => $order->payer_email])->count() == 1)) {
                                \Yii::$app->telegram->sendMessage(['chat_id' => $telegramUsers->ref, 'text' => 'По вашему промокоду покупали подписку. Мы дарим вам 3 дня VIP подписки']);
                                $refAccs = Accs::find()->where(['chatId' => $telegramUsers->ref])->one();
                                if(!empty($refAccs)) {
                                    $refAccs->tariff = "Premium";
                                    $refAccs->background_work =1;
                                    $refAccs->untildate = $user->untildate < time() ? (time() + 3*27*3600) : $user->untildate + 3*27*3600;
                                    $refAccs->save();
                                }
                            }
                            \Yii::$app->telegram->sendMessage([
                                'chat_id' => $order->payer_email,
                                'text' => 'Спасибо за покупку. Ваша подписка активирована!
Если вы еще не настроили VPN нажмите настроить VPN или напишите в поддержку, мы с радостью поможем разобраться.
Для управления подпиской, выберите в меню "Управление подпиской" ',

                            ]);
                        }

                        $this->saveEvent($user->user_id, $order->amount . " руб. " . $countDay . ' дней');
                        $mailer->sendPaymentMessage($user, $countDay, date("d.m.Y", $user->untildate));
                    }
                }
            }
        }
        return true;
    }

    public function saveEvent($userId, $text)
    {
        $event = new UserEvents();
        $event->user_id = (int)$userId;
        $event->event = (string)UserEvents::EVENT_PAYOUT;
        $event->text = $text;
        $event->save(false);
    }


}
