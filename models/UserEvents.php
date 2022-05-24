<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_events".
 *
 * @property int $id
 * @property string $datetime
 * @property int $user_id
 * @property string $event
 * @property string $text
 */
class UserEvents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime'], 'safe'],
            [['user_id', 'event', 'text'], 'required'],
            [['user_id'], 'integer'],
            [['text'], 'string'],
            [['event'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Дата время',
            'user_id' => 'Пользователь',
            'event' => 'События',
            'text' => 'Текст',
        ];
    }
}
