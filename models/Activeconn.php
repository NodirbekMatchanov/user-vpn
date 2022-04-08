<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activeconn".
 *
 * @property int $id
 * @property int $radcheck_id
 * @property int|null $ipsec_conn
 * @property int|null $opvn_conn
 * @property int|null $wg_conn
 * @property string $serv_ip
 */
class Activeconn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activeconn';
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
            [['radcheck_id', 'serv_ip'], 'required'],
            [['radcheck_id', 'ipsec_conn', 'opvn_conn', 'wg_conn'], 'integer'],
            [['serv_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'radcheck_id' => 'Radcheck ID',
            'ipsec_conn' => 'Ipsec Conn',
            'opvn_conn' => 'Opvn Conn',
            'wg_conn' => 'Wg Conn',
            'serv_ip' => 'Serv Ip',
        ];
    }
}
