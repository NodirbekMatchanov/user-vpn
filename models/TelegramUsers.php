<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telegram_users".
 *
 * @property int $chat_id
 * @property string|null $email
 * @property string $created
 * @property string|null $status
 * @property string|null $ref
 * @property string|null $tariff
 */
class TelegramUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['chat_id'], 'integer'],
            [['created'], 'safe'],
            [['email', 'status', 'ref'], 'string', 'max' => 255],
            [['tariff'], 'string', 'max' => 50],
            [['chat_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'email' => 'Email',
            'created' => 'Created',
            'status' => 'Status',
            'ref' => 'Ref',
            'tariff' => 'Tariff',
        ];
    }
}
