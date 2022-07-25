<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "used_promocodes".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $status
 * @property string $promocode
 * @property string $date
 * @property string|null $type
 */
class UsedPromocodes extends \yii\db\ActiveRecord
{
    const VISIT = 'visit';
    const SIGNUP = 'signup';
    const PAYOUT = 'payout';
    const USED = 'used';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'used_promocodes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','status'], 'integer'],
            [['promocode', 'date'], 'required'],
            [['date'], 'safe'],
            [['promocode'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'promocode' => 'Promocode',
            'date' => 'Date',
            'type' => 'Type',
        ];
    }

    public static function saveVisit($userId, $promocode)
    {
        $usedModel = new UsedPromocodes();
        $usedModel->type = UsedPromocodes::VISIT;
        $usedModel->user_id = $userId;
        $usedModel->promocode = $promocode;
        $usedModel->date = date("Y-m-d");
        $usedModel->save();
    }

    public static function saveSignup($userId, $promocode)
    {
        $usedModel = new UsedPromocodes();
        $usedModel->type = UsedPromocodes::SIGNUP;
        $usedModel->user_id = $userId;
        $usedModel->promocode = $promocode;
        $usedModel->date = date("Y-m-d");
        $usedModel->save();
    }

    public static function saveUsePromo($userId, $promocode)
    {
        $usedModel = new UsedPromocodes();
        $usedModel->type = UsedPromocodes::USED;
        $usedModel->user_id = $userId;
        $usedModel->promocode = $promocode;
        $usedModel->date = date("Y-m-d");
        $usedModel->save();
    }

    public static function savePayout($userId, $promocode)
    {
        $usedModel = new UsedPromocodes();
        $usedModel->type = UsedPromocodes::PAYOUT;
        $usedModel->user_id = $userId;
        $usedModel->promocode = $promocode;
        $usedModel->date = date("Y-m-d");
        $usedModel->save();
    }

    public static function ValidationPromoCode($code, $email = false) {
        /*промокод юсера*/
        $userPromo = Accs::find()->where(['promocode' => $code])->one();

        if($email) {
            $user = Accs::find()->where(['email' => $email])->one();
            $usedCodeUser = UsedPromocodes::find()->where(['promocode' => $code, 'user_id' => $user->user_id])->count();
            if($usedCodeUser > 0) {
                return json_encode(['result' => 'error', 'error' => 'Промокод уже использован']);
            }
        }
        if (!empty($userPromo)) {
            return json_encode(['result' => 'user-promocode']);
        }

        /*прокод админа*/
        $usedCodeCounts = UsedPromocodes::find()->where(['promocode' => $code])->andWhere(['!=', 'type', UsedPromocodes::VISIT])->count();

        $promoCode = Promocodes::find()->where(['promocode' => $code, 'status' => \app\models\Tariff::ACTIVE])->one();
        if (empty($usedCodes) && !empty($promoCode)) {
            if ($promoCode->user_limit <= $usedCodeCounts) {
                return json_encode(['result' => 'error', 'error' => 'Промокод уже использован']);
            } elseif (strtotime($promoCode->expire) < time()) {
                return json_encode(['result' => 'error', 'error' => 'Время использования промокода истек']);
            }
            return json_encode(['result' => 'success', 'description' => $promoCode->description]);
        }
        return json_encode(['result' => 'error', 'error' => 'Промокод не найден']);
    }

    public static function usePromocode($userId, $promocode, $type = null)
    {
        $isTelegram = false;

        $promocodeModel = Promocodes::find()->where(['promocode' => $promocode])->one();
        if (strtotime($promocodeModel->expire) >= time()) {
            $accs = Accs::find()->where(['user_id' => $userId])->one();
            if(empty($accs)) {
                $accs = Accs::find()->where(['chatId' => $userId])->one();
                $isTelegram = true;
            }
            $usedCodeCounts = UsedPromocodes::find()->where(['promocode' => $promocode])->andWhere(['!=', 'type', UsedPromocodes::VISIT])->count();
            if ($promocodeModel->user_limit <= $usedCodeCounts) {
                return json_encode(['result' => 'error', 'error' => 'Промокод уже использован']);
            }
            $accs->untildate = date("Y-m-d",$accs->untildate) < date("Y-m-d") ? time() + (3600 * 24 * $promocodeModel->free_day) : $accs->untildate + (3600 * 24 * $promocodeModel->free_day);
            $accs->tariff = "Premium";
            $accs->background_work = 1;
            $accs->save();

            $mailer = new Mailer();
            if($promocodeModel->user_id) {
                // привязанный пользователь к промокоду
                $user = Accs::find()->where(['user_id' => $promocodeModel->user_id])->one();
                $user->untildate = date("Y-m-d",$user->untildate) < date("Y-m-d") ? time() + (3600 * 24 * $promocodeModel->freeday_partner) : $user->untildate + (3600 * 24 * $promocodeModel->freeday_partner);
                $user->save();
                if(!$isTelegram){
                    $mailer->sendUsedPromocode($user,$promocodeModel->freeday_partner);

                }
                /* add event */
                $event = new UserEvents();
                $event->event = (string)UserEvents::EVENT_FREEDAY_PROMOCODE;
                $event->user_id = $user->user_id;
                $event->text = 'Начислено бесплатные дни : ' . $promocodeModel->freeday_partner.' дней';
                $event->save(false);

            }
            $mailer->sendUsedPromocode($accs,$promocodeModel->free_day);

            if(!$type) {
                /* add event */
                $event = new UserEvents();
                $event->event = (string)UserEvents::EVENT_REGISTRATION_PROMOCODE;
                $event->user_id = $userId;
                $event->text = 'регистрация по промо-коду : ' . $promocode;
                $event->save(false);
                self::saveSignup($userId,$promocode);
            } else {
                $event = new UserEvents();
                $event->event = (string)UserEvents::EVENT_USER_USED_PROMOCODE;
                $event->user_id = $userId;
                $event->text = 'Юсер применил промо-код : ' . $promocode;
                $event->save(false);
                self::saveUsePromo($userId,$promocode);
            }

            /* add event */
            $event = new UserEvents();
            $event->event = (string)UserEvents::EVENT_FREEDAY_PROMOCODE;
            $event->user_id = $userId;
            $event->text = 'Начислено бесплатные дни : ' . $promocodeModel->free_day .' дней';
            $event->save(false);

            return true;
        } else {
            return 'expire';
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(Promocodes::className(), ['promocode' => 'promocode']);
    }

    public function getHistory($data) {
        $accs = Accs::find()->where(['email' => $data['email']])->one();
        if(!empty($accs)) {
            $query = UsedPromocodes::find();
            $query->andWhere(['user_id' => $accs->user_id]);
            $history = $query->all();
            return $history;
        }
        return [];
    }

    public function getStatByPromocode($data) {
//        if(!empty($data['email'])) {
//            $accs = Accs::find()->where(['email' => $data['email']])->one();
//            $usedSignup = \app\models\UsedPromocodes::find()->where(['user_id' => $accs->user_id,'promocode' => $data['promocode'], 'type' => \app\models\UsedPromocodes::SIGNUP])->count();
//            $usedPayout = \app\models\UsedPromocodes::find()->where(['user_id' => $accs->user_id, 'promocode' => $data['promocode'], 'type' => \app\models\UsedPromocodes::PAYOUT])->count();
//        } else {
            $usedSignup = \app\models\UsedPromocodes::find()->where(['promocode' => $data['promocode'], 'type' => \app\models\UsedPromocodes::SIGNUP])->count();
            $usedPayout = \app\models\UsedPromocodes::find()->where(['promocode' => $data['promocode'], 'type' => \app\models\UsedPromocodes::PAYOUT])->count();
//        }
         return [
            'signupCount' => $usedSignup,
            'payoutCount' => $usedPayout,
        ];
    }

    public function savePromocode($data) {

    }

}
