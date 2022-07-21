<?php

namespace app\models;

use app\models\user\Profile;
use Yii;

/**
 * This is the model class for table "accs".
 *
 * @property int $id
 * @property string $email
 * @property string $pass
 * @property int $vpnid
 * @property int $untildate
 * @property int $datecreate
 * @property int $promo_share
 * @property string $status
 * @property string $utm_source
 * @property string $utm_medium
 * @property string $utm_campaign
 * @property string $utm_term
 * @property string $used_promocode
 * @property string $background_work
 * @property string $country
 * @property string $source
 * @property string $subscribe
 * @property string $tmp_pass
 */
class Accs extends \yii\db\ActiveRecord
{

    const SOURCE_WEB = 'web';
    const SOURCE_TELEGRAM = 'telegram';
    const SOURCE_IOS = 'ios';
    const SOURCE_ANDROID = 'android';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accs';
    }

    public static function getDb()
    {
        return \Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'pass', 'vpnid', 'untildate', 'datecreate', 'status'], 'required'],
            [['vpnid','background_work', 'untildate', 'datecreate','promo_share', 'test_user','user_id', 'use_android', 'visit_count', 'use_ios', 'verifyCode'], 'integer'],
            [['comment','used_promocode','tmp_pass', 'use_ios', 'fcm_token'], 'string'],
            [['email','utm_term','source','utm_campaign','chatId','utm_medium','utm_source', 'pass', 'role', 'tariff', 'promocode'], 'string', 'max' => 255],
            [['status', 'reset_pass','subscribe','country'], 'string', 'max' => 50],
            [['last_date_visit'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'pass' => 'Pass',
            'vpnid' => 'Vpnid',
            'untildate' => 'Untildate',
            'datecreate' => 'Datecreate',
            'status' => 'Status',
        ];
    }

    public static function getAccs()
    {
        $userId = Yii::$app->user->identity->getId();
        $accs = Accs::find()->where(['user_id' => $userId])->one();
        return $accs;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfil()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */

    public function getVpn()
    {
        return $this->hasOne(VpnUserSettings::className(), ['id' => 'vpnid']);
    }

    public static function setPromoShareCount($promocode, $user, $chatId = null){
        if($promocode == "") return false;
        $accs = Accs::find()->where(['promocode' => $promocode])->one();
        if($user) {
            $usedCodeUser = UsedPromocodes::find()->where(['promocode' => $promocode, 'user_id' => ($user->id ?? $user->user_id)])->count();
            if($usedCodeUser > 0) {
                return false;
            }
        }
        if(!empty($accs)) {
           $count = $accs->promo_share;
           $accs->promo_share = $count + 1;
           $accs->background_work = 1;
           $accs->untildate = $accs->untildate < time() ? time() + (3600*24*1) : $accs->untildate + (3600*24*1);
           UsedPromocodes::saveSignup(($user->user_id ?? $user->id),$promocode);
           $mailer = new Mailer();
           $mailer->sendUsedPromocode($accs, 1);

           $mailer = new Mailer();
           $mailer->sendUsedPromocode($user,1);

            /* add event */
            $event = new UserEvents();
            $event->event = (string)UserEvents::EVENT_FREEDAY_PROMOCODE;
            $event->user_id = ($user->user_id ?? $user->id);
            $event->text = 'Начислено бесплатные дни : 1 день';
            $event->save(false);

            /* add event */
            $event = new UserEvents();
            $event->event = (string)UserEvents::EVENT_FREEDAY_PROMOCODE;
            $event->user_id = ($accs->user_id);
            $event->text = 'Начислено бесплатные дни : 1 день';
            $event->save(false);

            return $accs->save();
        } else {
            if($chatId) {
                return UsedPromocodes::usePromocode($chatId,$promocode);
            }
           return UsedPromocodes::usePromocode(($user->id),$promocode);
        }
        return false;
    }
}
