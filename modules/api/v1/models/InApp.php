<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "in_app".
 *
 * @property int $id
 * @property int $receipt_apple_id
 * @property int $quantity
 * @property string $product_id
 * @property string $transaction_id
 * @property string $original_transaction_id
 * @property string $purchase_date
 * @property string $purchase_date_ms
 * @property string $purchase_date_pst
 * @property string $original_purchase_date
 * @property string $original_purchase_date_ms
 * @property string $original_purchase_date_pst
 * @property string $is_trial_period
 * @property string $in_app_ownership_type
 */
class InApp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'in_app';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_apple_id', 'quantity', 'product_id', 'transaction_id', 'original_transaction_id', 'purchase_date', 'purchase_date_ms', 'purchase_date_pst', 'original_purchase_date', 'original_purchase_date_ms', 'original_purchase_date_pst', 'is_trial_period', 'in_app_ownership_type'], 'required'],
            [['receipt_apple_id', 'quantity', ], 'integer'],
            ['transaction_id', 'unique'],
            [['product_id', 'transaction_id','is_trial_period', 'original_transaction_id', 'purchase_date', 'purchase_date_ms', 'purchase_date_pst', 'original_purchase_date', 'original_purchase_date_ms', 'original_purchase_date_pst', 'in_app_ownership_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receipt_apple_id' => 'Receipt Apple ID',
            'quantity' => 'Quantity',
            'product_id' => 'Product ID',
            'transaction_id' => 'Transaction ID',
            'original_transaction_id' => 'Original Transaction ID',
            'purchase_date' => 'Purchase Date',
            'purchase_date_ms' => 'Purchase Date Ms',
            'purchase_date_pst' => 'Purchase Date Pst',
            'original_purchase_date' => 'Original Purchase Date',
            'original_purchase_date_ms' => 'Original Purchase Date Ms',
            'original_purchase_date_pst' => 'Original Purchase Date Pst',
            'is_trial_period' => 'Is Trial Period',
            'in_app_ownership_type' => 'In App Ownership Type',
        ];
    }
}
