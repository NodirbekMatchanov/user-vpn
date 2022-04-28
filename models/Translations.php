<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "translations".
 *
 * @property int $id
 * @property string $device
 * @property string $page
 * @property string $element_type
 * @property string $description
 * @property string $country
 * @property string $date
 */
class Translations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device', 'page', 'element_type', 'description', 'country', 'date'], 'required'],
            [['description'], 'string'],
            [['date'], 'safe'],
            [['device', 'page', 'element_type'], 'string', 'max' => 50],
            [['country'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device' => 'Размещение',
            'page' => 'Экран',
            'element_type' => 'Тип элемента ',
            'description' => 'Описание',
            'country' => 'Страна',
            'date' => 'Дата',
        ];
    }


}
