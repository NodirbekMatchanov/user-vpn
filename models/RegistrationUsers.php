<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registration_users".
 *
 * @property int $id
 * @property string $email
 * @property string|null $password
 * @property string|null $source
 * @property string|null $promocode
 * @property string|null $lang
 * @property string|null $country
 * @property string $created
 * @property string|null $verifyCode
 */
class RegistrationUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registration_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['created'], 'safe'],
            [['email', 'country'], 'string', 'max' => 255],
            [['password', 'source', 'promocode', 'lang', 'verifyCode'], 'string', 'max' => 50],
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
            'password' => 'Password',
            'source' => 'Source',
            'promocode' => 'Promocode',
            'lang' => 'Lang',
            'country' => 'Country',
            'created' => 'Created',
            'verifyCode' => 'Verify Code',
        ];
    }
}
