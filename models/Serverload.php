<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "serverload".
 *
 * @property int $id
 * @property string $ipaddr
 * @property string|null $descr
 * @property int $la
 */
class Serverload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'serverload';
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
            [['ipaddr', 'la'], 'required'],
            [['la'], 'integer'],
            [['ipaddr'], 'string', 'max' => 15],
            [['descr'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ipaddr' => 'Ipaddr',
            'descr' => 'Descr',
            'la' => 'La',
        ];
    }
}
