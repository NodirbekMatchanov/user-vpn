<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "user_tokens".
 *
 * @property int $id
 * @property string|null $source
 * @property string|null $name
 * @property string $token
 * @property string $auth_key
 * @property int $status
 * @property string $last_login
 * @property string $user_id
 * @property string $language
 * @property string $version
 * @property string $deviceid
 */
class UserTokens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token','user_id', 'auth_key', 'status', 'last_login'], 'required'],
            [['token','deviceid'], 'string'],
            [['status'], 'integer'],
            [['last_login'], 'safe'],
            [['source', 'name','version'], 'string', 'max' => 50],
            [['auth_key','language'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'name' => 'Name',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'last_login' => 'Last Login',
        ];
    }
}
