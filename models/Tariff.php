<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tariff".
 *
 * @property int $id
 * @property int $status
 * @property float $price
 * @property int $period
 * @property string|null $country
 * @property string|null $currency
 * @property string|null $expire
 * @property string|null $name
 */
class Tariff extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const ARCHIVE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'price', 'period'], 'required'],
            [['status', 'period'], 'integer'],
            [['price'], 'number'],
            [['expire'], 'safe'],
            [['country','name'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название тарифа',
            'status' => 'Статус',
            'price' => 'Цена',
            'period' => 'Период',
            'country' => 'Страна',
            'currency' => 'Валюта',
            'expire' => 'Действует до',
        ];
    }

    public static function getAllList(){
        $tariffs = Tariff::find()->all();
        return !empty($tariffs) ? ArrayHelper::map($tariffs,'id','name') : [] ;
    }
}
