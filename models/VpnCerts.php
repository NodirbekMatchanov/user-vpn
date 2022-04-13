<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vpn_certs".
 *
 * @property int $id
 * @property string $cert_type
 * @property string $file
 * @property int $ip_id
 */
class VpnCerts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vpn_certs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cert_type', 'file', 'ip_id'], 'required'],
            [['ip_id'], 'integer'],
            [['cert_type'], 'string', 'max' => 50],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cert_type' => 'Type',
            'file' => 'File',
            'ip_id' => 'Ip ID',
        ];
    }
}
