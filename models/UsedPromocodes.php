<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "used_promocodes".
 *
 * @property int $id
 * @property int $user_id
 * @property string $promocode
 * @property string $date
 */
class UsedPromocodes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'used_promocodes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'promocode', 'date'], 'required'],
            [['user_id'], 'integer'],
            [['date'], 'safe'],
            [['promocode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promocode' => 'Промокод',
            'date' => 'Дата применения',
        ];
    }
}
