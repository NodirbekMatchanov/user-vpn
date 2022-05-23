<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "used_promocodes".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $promocode
 * @property string $date
 * @property string|null $type
 */
class UsedPromocodes extends \yii\db\ActiveRecord
{
    const VISIT = 'visit';
    const SIGNUP = 'signup';
    const PAYOUT = 'payout';

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
            [['user_id'], 'integer'],
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

    public static function ValidationPromoCode($code) {
        /*промокод юсера*/
        $userPromo = Accs::find()->where(['promocode' => $code])->one();
        if (!empty($userPromo)) {
            return json_encode(['result' => 'user-promocode']);
        }

        /*прокод админа*/
        $usedCodeCounts = UsedPromocodes::find()->where(['promocode' => $code])->andWhere(['!=', 'type', UsedPromocodes::VISIT])->count();
        $promoCode = Promocodes::find()->where(['promocode' => $code, 'status' => \app\models\Tariff::ACTIVE])->one();
        if (empty($usedCodes) && !empty($promoCode)) {
            if ($promoCode->user_limit < $usedCodeCounts) {
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
        $promocodeModel = Promocodes::find()->where(['promocode' => $promocode])->one();
        if (strtotime($promocodeModel->expire) >= time()) {
            $accs = Accs::find()->where(['user_id' => $userId])->one();
            $usedCodeCounts = UsedPromocodes::find()->where(['promocode' => $promocode])->andWhere(['!=', 'type', UsedPromocodes::VISIT])->count();
            if ($promocodeModel->user_limit < $usedCodeCounts) {
                return json_encode(['result' => 'error', 'error' => 'Промокод уже использован']);
            }
            $accs->untildate = $accs->untildate < time() ? time() + (3600 * $promocodeModel->free_day) : $accs->untildate + (3600 * $promocodeModel->free_day);
            $accs->save();

            self::saveSignup($userId,$promocode);

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

}
