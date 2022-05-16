<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "appAccountToken".
 *
 * @property int $user_id
 * @property string $account_token
 */
class AppAccountToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appAccountToken';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'account_token'], 'required'],
            [['user_id'], 'integer'],
            [['account_token'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'account_token' => 'Account Token',
        ];
    }
}
