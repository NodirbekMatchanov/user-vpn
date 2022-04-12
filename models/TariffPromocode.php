<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tariff_promocode".
 *
 * @property int $tariff_id
 * @property int $promocode_id
 */
class TariffPromocode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariff_promocode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tariff_id', 'promocode_id'], 'required'],
            [['tariff_id', 'promocode_id'], 'integer'],
            [['tariff_id', 'promocode_id'], 'unique', 'targetAttribute' => ['tariff_id', 'promocode_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tariff_id' => 'Tariff ID',
            'promocode_id' => 'Promocode ID',
        ];
    }
}
