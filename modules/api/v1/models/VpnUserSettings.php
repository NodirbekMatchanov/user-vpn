<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "vpn_user_settings".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $attribute
 * @property string|null $op
 * @property string|null $value
 */
class VpnUserSettings extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'radcheck';
    }

    public static function getDb()
    {
        return \Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'value'], 'required'],
            [['op', 'untildate'], 'safe'],
            ['username', 'unique'],
            [['value', 'attribute', 'op'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        $this->op = ':=';
        $this->attribute = 'Cleartext-Password';
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


}
