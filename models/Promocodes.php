<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promocodes".
 *
 * @property int $id
 * @property string $promocode
 * @property string $expire
 * @property string|null $date_start
 * @property int|null $user_limit
 * @property string|null $status
 * @property string|null $description
 * @property float|null $discount
 * @property int|null $free_day
 * @property int|null $freeday_partner
 * @property string|null $comment
 * @property string|null $author
 * @property string|null $country
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $user_id
 */
class Promocodes extends \yii\db\ActiveRecord
{

    public $users = [];
    public $tariffs = [];
    public $visit;
    public $payout;
    public $signup;
    public $konverstion;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promocodes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promocode', 'expire'], 'required'],
            [['expire', 'date_start', 'user_id', 'users', 'tariffs', 'created_at', 'updated_at'], 'safe'],
            [['user_limit','freeday_partner', 'free_day'], 'integer'],
            [['description', 'comment'], 'string'],
            [['discount'], 'number'],
            [['promocode'], 'unique', 'targetAttribute' => ['promocode']],
            [['promocode', 'status', 'author', 'country'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'promocode' => 'Промокод',
            'expire' => 'Действует до',
            'tariffs' => 'Привязка к тарифам',
            'users' => 'Привязка к пользователям',
            'user_id' => 'Привязка к пользователям',
            'date_start' => 'Действует с',
            'user_limit' => 'Лимит регистраций',
            'status' => 'Статус',
            'description' => 'Описание',
            'discount' => 'Скидка %',
            'free_day' => 'Подарочные дни',
            'freeday_partner' => 'Подарочные дни партнера',
            'comment' => 'Комментарии',
            'author' => 'Автор',
            'country' => 'Страна',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'visit' => 'Посетителей',
            'signup' => 'Регистраций',
            'payout' => 'Оплат',
            'konverstion' => 'Конверсия',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {

        if (!empty($this->users)) {
            if ($old = UsersPromocode::find()->where(['promocode_id' => $this->id])->one()) {
                $old->delete();
            }
            $userPromocode = new UsersPromocode();
            $userPromocode->user_id = $this->users;
            $userPromocode->promocode_id = $this->id;
            $userPromocode->save();
        }

        if (!empty($this->tariffs)) {
            if ($old = TariffPromocode::find()->where(['promocode_id' => $this->id])->one()) {
                $old->delete();
            }
            foreach ($this->tariffs as $tariff) {
                $tariffPromocode = new TariffPromocode();
                $tariffPromocode->tariff_id = $tariff;
                $tariffPromocode->promocode_id = $this->id;
                $tariffPromocode->save();
            }
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
