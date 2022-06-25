<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telegram_managers".
 *
 * @property int $chat_id
 */
class TelegramManagers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_managers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['chat_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
        ];
    }
}
