<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_usage_by_period".
 *
 * @property string $username
 * @property string $period_start
 * @property string|null $period_end
 * @property int|null $acctinputoctets
 * @property int|null $acctoutputoctets
 * @property int|null $acctsessiontime
 */
class DataUsageByPeriod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_usage_by_period';
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
            [['username', 'period_start'], 'required'],
            [['period_start', 'period_end'], 'safe'],
            [['acctinputoctets', 'acctoutputoctets', 'acctsessiontime'], 'integer'],
            [['username'], 'string', 'max' => 64],
            [['username', 'period_start'], 'unique', 'targetAttribute' => ['username', 'period_start']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'period_start' => 'Period Start',
            'period_end' => 'Period End',
            'acctinputoctets' => 'Acctinputoctets',
            'acctoutputoctets' => 'Acctoutputoctets',
            'acctsessiontime' => 'Acctsessiontime',
        ];
    }
}
