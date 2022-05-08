<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "receipt_apple".
 *
 * @property int $id
 * @property string $receipt_type
 * @property int|null $adam_id
 * @property int|null $app_item_id
 * @property string|null $bundle_id
 * @property string|null $application_version
 * @property int|null $download_id
 * @property int|null $version_external_identifier
 * @property string|null $receipt_creation_date
 * @property string|null $receipt_creation_date_ms
 * @property string|null $receipt_creation_date_pst
 * @property string|null $request_date
 * @property string|null $request_date_ms
 * @property string|null $request_date_pst
 * @property string|null $original_purchase_date
 * @property string|null $original_purchase_date_ms
 * @property string|null $original_purchase_date_pst
 * @property string|null $original_application_version
 * @property string|null $environment
 * @property int $status
 */
class ReceiptApple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt_apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_type', 'status'], 'required'],
            [['adam_id', 'app_item_id', 'download_id','version_external_identifier', 'status'], 'integer'],
            [['receipt_type', 'bundle_id', 'application_version', 'receipt_creation_date', 'receipt_creation_date_ms', 'receipt_creation_date_pst', 'request_date', 'request_date_ms', 'request_date_pst', 'original_purchase_date', 'original_purchase_date_ms', 'original_purchase_date_pst'], 'string', 'max' => 255],
            [['original_application_version', 'environment'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receipt_type' => 'Receipt Type',
            'adam_id' => 'Adam ID',
            'app_item_id' => 'App Item ID',
            'bundle_id' => 'Bundle ID',
            'application_version' => 'Application Version',
            'download_id' => 'Download ID',
            'version_external_identifier' => 'Version External Identifier',
            'receipt_creation_date' => 'Receipt Creation Date',
            'receipt_creation_date_ms' => 'Receipt Creation Date Ms',
            'receipt_creation_date_pst' => 'Receipt Creation Date Pst',
            'request_date' => 'Request Date',
            'request_date_ms' => 'Request Date Ms',
            'request_date_pst' => 'Request Date Pst',
            'original_purchase_date' => 'Original Purchase Date',
            'original_purchase_date_ms' => 'Original Purchase Date Ms',
            'original_purchase_date_pst' => 'Original Purchase Date Pst',
            'original_application_version' => 'Original Application Version',
            'environment' => 'Environment',
            'status' => 'Status',
        ];
    }
}
