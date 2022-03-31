<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail_template".
 *
 * @property int $id
 * @property string $subject
 * @property string $body
 * @property string $from
 */
class MailTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'body'], 'required'],
            [['body'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['from','tmp_key'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'body' => 'Body',
            'from' => 'From',
        ];
    }
}
