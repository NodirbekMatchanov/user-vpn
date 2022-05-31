<?php

namespace app\models;

use app\components\DateFormat;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tariff".
 *
 * @property int $id
 * @property int $status
 * @property float $price
 * @property int $period
 * @property string|null $country
 * @property string|null $currency
 * @property string|null $expire
 * @property string|null $name
 */
class Tariff extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const ARCHIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'price'], 'required'],
            [['status', 'period', 'day_7', 'day_30', 'day_180', 'day_365'], 'integer'],
            [['price', 'price_7', 'price_30', 'price_180', 'price_365'], 'number'],
            [['expire'], 'safe'],
            [['country', 'name'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название тарифа',
            'status' => 'Статус',
            'price' => 'Цена',
            'period' => 'Период',
            'country' => 'Страна',
            'currency' => 'Валюта',
            'expire' => 'Действует до',
            'day_7' => '7 дней',
            'day_30' => '30 дней',
            'day_180' => '180 дней',
            'day_365' => '365 дней',
            'price_7' => 'цена 7 дней',
            'price_30' => 'цена 30 дней',
            'price_180' => 'цена 180 дней',
            'price_365' => 'цена 365 дней',
        ];
    }

    public static function getAllList()
    {
        $tariffs = Tariff::find()->all();
        return !empty($tariffs) ? ArrayHelper::map($tariffs, 'id', 'name') : [];
    }

    public static function getTariffs()
    {
        $tariffs = Tariff::find()->all();
        return $tariffs;
    }

    public static function getPeriod($id)
    {
        $tariffs = Tariff::find()->all();
        foreach ($tariffs as $tariff) {
            if ($id == '1_month') {
                return  30;
            } else if ($id == '6_month') {
                return  180;
            } else if ($id == '12_month') {
                return  365;
            }
        }
    }

    /* проверка срок подписки */
    public static function checkUsersTariff() {
        $users = Accs::find()->where(['status' => VpnUserSettings::$statuses['ACTIVE']])->all();
        $mailer = new Mailer();
        foreach ($users as $user) {
            if(date("Y-m-d", $user->untildate) == date("Y-m-d")) {
            } elseif (DateFormat::countDaysBetweenDates($user->untildate, time()) < 1) {
                $mailer->sendExpire($user);

                $user->status = VpnUserSettings::$statuses["EXPIRE"];
                $user->save();

            } elseif (DateFormat::countDaysBetweenDates($user->untildate, time()) == 1) {
                $mailer->sendExpireDay($user);
            }
        }
    }
}
