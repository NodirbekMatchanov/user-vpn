<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_useage_stat".
 *
 * @property string $username
 * @property string $last_usage_date
 * @property int $usage_count
 */
class UserUseageStat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_useage_stat';
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
            [['username', 'last_usage_date', 'usage_count'], 'required'],
            [['last_usage_date'], 'safe'],
            [['usage_count'], 'integer'],
            [['username'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'last_usage_date' => 'Last Usage Date',
            'usage_count' => 'Usage Count',
        ];
    }
}
