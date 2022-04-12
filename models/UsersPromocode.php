<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_promocode".
 *
 * @property int $user_id
 * @property int $promocode_id
 */
class UsersPromocode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_promocode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'promocode_id'], 'required'],
            [['user_id', 'promocode_id'], 'integer'],
            [['user_id', 'promocode_id'], 'unique', 'targetAttribute' => ['user_id', 'promocode_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'promocode_id' => 'Promocode ID',
        ];
    }
}
