<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "used_promocodes".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $promocode
 * @property string $date
 * @property string|null $type
 */
class UsedPromocodes extends \yii\db\ActiveRecord
{
    const VISIT = 'visit';
    const SIGNUP = 'signup';
    const PAYOUT = 'payout';
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
            [['user_id'], 'integer'],
            [['promocode', 'date'], 'required'],
            [['date'], 'safe'],
            [['promocode'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'promocode' => 'Promocode',
            'date' => 'Date',
            'type' => 'Type',
        ];
    }

    public static function saveVisit($userId,$promocode){
        $usedModel = new UsedPromocodes();
        $usedModel->type = UsedPromocodes::VISIT;
        $usedModel->user_id = $userId;
        $usedModel->promocode = $promocode;
        $usedModel->date = date("Y-m-d");
        $usedModel->save();
    }

    public static function saveSignup($userId,$promocode){
        $usedModel = new UsedPromocodes();
        $usedModel->type = UsedPromocodes::SIGNUP;
        $usedModel->user_id = $userId;
        $usedModel->promocode = $promocode;
        $usedModel->date = date("Y-m-d");
        $usedModel->save();
    }
}
