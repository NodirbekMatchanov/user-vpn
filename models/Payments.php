<?php

namespace app\models;

use Yii;

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
 * @property int $promocode
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
            [[ 'user_id', 'status','app_transaction_id'], 'integer'],
            [['datecreate'], 'safe'],
            [['amount'], 'number'],
            [['tariff','source','payer_email','promocode','type','orderId'], 'string', 'max' => 50],
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


}
