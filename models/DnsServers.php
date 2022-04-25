<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dns_servers".
 *
 * @property int $id
 * @property string $name
 * @property string $ip
 * @property string $status
 */
class DnsServers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dns_servers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'ip', 'status'], 'required'],
            [['name', 'ip'], 'string', 'max' => 255],
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
            'name' => 'Название',
            'ip' => 'Ip',
            'status' => 'Статус',
        ];
    }
}
