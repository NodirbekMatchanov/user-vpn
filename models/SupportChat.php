<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_chat".
 *
 * @property int $id
 * @property int $chatId
 * @property int|null $managerId
 * @property string $message
 * @property string $created
 * @property int $is_new
 */
class SupportChat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support_chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chatId', 'message'], 'required'],
            [['chatId', 'managerId', 'is_new'], 'integer'],
            [['message'], 'string'],
            [['created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chatId' => 'Chat ID',
            'managerId' => 'Manager ID',
            'message' => 'Message',
            'created' => 'Created',
            'is_new' => 'Is New',
        ];
    }
}
