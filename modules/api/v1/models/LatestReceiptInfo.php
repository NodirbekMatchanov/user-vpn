<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "latest_receipt_info".
 *
 * @property int $id
 * @property int $receipt_apple_id
 * @property string $product_id
 * @property string $transaction_id
 * @property string|null $original_transaction_id
 * @property string|null $purchase_date
 * @property string|null $purchase_date_ms
 * @property string|null $purchase_date_pst
 * @property string|null $original_purchase_date
 * @property string|null $original_purchase_date_ms
 * @property string|null $original_purchase_date_pst
 * @property string|null $expires_date
 * @property string|null $expires_date_ms
 * @property string|null $expires_date_pst
 * @property string|null $web_order_line_item_id
 * @property int|null $is_trial_period
 * @property int|null $is_in_intro_offer_period
 * @property string|null $in_app_ownership_type
 * @property string|null $subscription_group_identifier
 */
class LatestReceiptInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'latest_receipt_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_apple_id', 'product_id', 'transaction_id'], 'required'],
            [['receipt_apple_id', 'is_trial_period', 'is_in_intro_offer_period'], 'integer'],
            [['product_id', 'transaction_id', 'original_transaction_id', 'purchase_date', 'purchase_date_ms', 'purchase_date_pst', 'original_purchase_date', 'original_purchase_date_ms', 'original_purchase_date_pst', 'expires_date', 'expires_date_ms', 'expires_date_pst', 'web_order_line_item_id', 'in_app_ownership_type', 'subscription_group_identifier'], 'string', 'max' => 255],
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
            'product_id' => 'Product ID',
            'transaction_id' => 'Transaction ID',
            'original_transaction_id' => 'Original Transaction ID',
            'purchase_date' => 'Purchase Date',
            'purchase_date_ms' => 'Purchase Date Ms',
            'purchase_date_pst' => 'Purchase Date Pst',
            'original_purchase_date' => 'Original Purchase Date',
            'original_purchase_date_ms' => 'Original Purchase Date Ms',
            'original_purchase_date_pst' => 'Original Purchase Date Pst',
            'expires_date' => 'Expires Date',
            'expires_date_ms' => 'Expires Date Ms',
            'expires_date_pst' => 'Expires Date Pst',
            'web_order_line_item_id' => 'Web Order Line Item ID',
            'is_trial_period' => 'Is Trial Period',
            'is_in_intro_offer_period' => 'Is In Intro Offer Period',
            'in_app_ownership_type' => 'In App Ownership Type',
            'subscription_group_identifier' => 'Subscription Group Identifier',
        ];
    }
}
