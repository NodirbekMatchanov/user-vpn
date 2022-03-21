<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vpn_user_settings".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $vpnlogin
 * @property string|null $vpnpassword
 * @property string|null $until
 * @property string|null $status
 */
class VpnUserSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vpn_user_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['until'], 'safe'],
            [['vpnlogin', 'vpnpassword'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
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
            'vpnlogin' => 'Vpnlogin',
            'vpnpassword' => 'Vpnpassword',
            'until' => 'Until',
            'status' => 'Status',
        ];
    }
}
