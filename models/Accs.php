<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accs".
 *
 * @property int $id
 * @property string $email
 * @property string $pass
 * @property int $vpnid
 * @property int $untildate
 * @property int $datecreate
 * @property string $status
 */
class Accs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accs';
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
            [['email', 'pass', 'vpnid', 'untildate', 'datecreate', 'status'], 'required'],
            [['vpnid', 'untildate', 'datecreate', 'test_user', 'use_android', 'visit_count', 'use_ios', 'verifyCode'], 'integer'],
            [['comment', 'use_ios', 'fcm_token'], 'string'],
            [['email', 'pass', 'role', 'tariff', 'promocode'], 'string', 'max' => 255],
            [['status', 'reset_pass'], 'string', 'max' => 50],
            [['last_date_visit'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'pass' => 'Pass',
            'vpnid' => 'Vpnid',
            'untildate' => 'Untildate',
            'datecreate' => 'Datecreate',
            'status' => 'Status',
        ];
    }

    public static function getAccs()
    {
        $userId = Yii::$app->user->identity->getId();
        $accs = Accs::find()->where(['user_id' => $userId])->one();
        return $accs;
    }
}
