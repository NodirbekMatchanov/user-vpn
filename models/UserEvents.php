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

    /* EVENTS */
    const EVENT_RUN_APP = 1;
    const EVENT_RUN_APP_BACKGROUND = 2;
    const EVENT_RUN_APP_BACKGROUND_OFF = 3;
    const EVENT_PAYOUT = 4;
    const EVENT_DELETE_ACCOUNT = 5;
    const EVENT_REGISTRATION_PROMOCODE = 6;
    const EVENT_FREEDAY_PROMOCODE = 7;

    /* EVENTS ru*/
    public static $eventsRu = [
        self::EVENT_RUN_APP => 'запускал приложение',
        self::EVENT_RUN_APP_BACKGROUND => 'запускал приложение в фоне',
        self::EVENT_RUN_APP_BACKGROUND_OFF => 'запускал приложение в фоне с отключенной фоновой работой',
        self::EVENT_PAYOUT => 'купил подписку',
        self::EVENT_DELETE_ACCOUNT => 'удалил экаунт',
        self::EVENT_REGISTRATION_PROMOCODE => 'регистрация по промо-коду',
        self::EVENT_FREEDAY_PROMOCODE => 'начислено бесплатные дни',
    ];

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
            [['user_id', 'event'], 'required'],
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
