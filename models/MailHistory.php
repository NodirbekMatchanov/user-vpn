<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail_history".
 *
 * @property int $id
 * @property string $subject
 * @property string $body
 * @property string $datecreate
 * @property string $email
 */
class MailHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'body', 'datecreate', 'email'], 'required'],
            [['body'], 'string'],
            [['datecreate'], 'safe'],
            [['subject', 'email'], 'string', 'max' => 255],
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
            'datecreate' => 'Datecreate',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Accs::className(), ['email' => 'email']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccs()
    {
        return $this->hasOne(Accs::className(), ['email' => 'email']);
    }
}
