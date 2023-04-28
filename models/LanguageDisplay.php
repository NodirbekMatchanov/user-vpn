<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "language_display".
 *
 * @property int $id
 * @property string $created_at
 * @property string $title
 * @property string $local_id
 * @property string $status
 */
class LanguageDisplay extends \yii\db\ActiveRecord
{

    public static $statuses = [
        1 => 'active', 2 => 'Test', 0 => 'inactive'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language_display';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['title', 'local_id'], 'required'],
            [['title', 'local_id'], 'string', 'max' => 50],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'title' => 'Название',
            'local_id' => 'local_id',
            'status' => 'Статус',
        ];
    }

    public static function getTranslations()
    {
        $languages = self::find()->all();
        return ArrayHelper::map($languages, 'local_id', 'title');
    }

    public static function getCurrentLanguage() {
        return  self::find()->andFilterWhere(['like', 'local_id', Yii::$app->language])->one()->id ?? '2';
    }
}
