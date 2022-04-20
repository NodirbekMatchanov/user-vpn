<?php

namespace app\models;

use app\models\user\Profile;
use dektrium\user\models\User;
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
    public $email;
    public $pass;
    public $vpnid;
    public $untildate;
    public $datecreate;
    public $status;
    public $sccId;
    public $tariff;
    public $role;
    public $comment;
    public $phone;
    public $use_ios;
    public $test_user;
    public $fcm_token;
    public $use_android;
    public $promocode;
    public $last_date_visit;
    public $visit_count;
    public $verifyCode;
    public $createAdmin = true;
    public $user_id;
    public $utm_source;
    public $utm_medium;
    public $utm_campaign;
    public $utm_term;
    public $used_promocode;
    public static $statuses = ['ACTIVE' => 'ACTIVE','FREE' => 'FREE','NOACTIVE' => 'NOACTIVE','EXPIRE' =>'EXPIRE','DELETED' => 'DELETED'];
    public static $roles = ['user' => 'user','moderator' => 'moderator','admin' =>'admin'];
    public static $tariffs = ['Free' => 'Free','Premium' => 'Premium','VIP' =>'VIP'];
    public static $types = ['Free' => 'Free','Paid' =>'Paid'];
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
            [['op','untildate', 'untildate'], 'safe'],
            ['username', 'unique'],
            ['email', 'check'],
            [['comment','use_ios','fcm_token'], 'string'],
            [['vpnid', 'test_user','datecreate','test_user','use_android','visit_count','use_ios','verifyCode'], 'integer'],
            [['last_date_visit'], 'safe'],
            [['value','phone','used_promocode','tariff', 'promocode','email', 'pass', 'status', 'username', 'attribute', 'op'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        $this->op = ':=';
        $this->attribute = 'Cleartext-Password';
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {

        if(!$acc = Accs::findOne($this->sccId)) {
            $acc = new Accs();
            if($this->createAdmin){
                $user = new User();
                $user->email = $this->email;
                $user->username = $this->email;
                $user->password = $this->pass;
                $user->register();
                $acc->user_id = $user->id;
            } else {
                $user = User::find()->where(['email' => $this->email])->one();
                $acc->user_id = $user->id;
            }
        }
        $user =  User::find()->where(['id' => $acc->user_id])->one();
        if(!empty($user)){
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->pass);
            $user->save();
        }

        $acc->email = $this->email;
        $acc->pass = $this->pass;
        $acc->vpnid = $this->id;
        $acc->status = $this->status;
        $acc->utm_source = $this->utm_source;
        $acc->utm_medium = $this->utm_medium;
        $acc->utm_campaign = $this->utm_campaign;
        $acc->utm_term = $this->utm_term;
        $acc->untildate = strtotime($this->untildate);
        $acc->datecreate = time();
        $acc->used_promocode = $this->used_promocode;
        $acc->promocode = Yii::$app->security->generateRandomString(6);
        $acc->tariff = $this->tariff;
        $acc->role = $this->role;
        $acc->comment = $this->comment;
        $acc->test_user = $this->test_user;
        if (!$acc->save()) {
            return false;
        }
        $profile = Profile::find()->where(['user_id' => $acc->user_id])->one();
        if(empty($profile)){
           $profile = new Profile();
           $profile->user_id = $acc->user_id;
        }
        $profile->phone = $this->phone;
        $profile->save(false);
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccs()
    {
        return $this->hasOne(Accs::className(), ['vpnid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccsp()
    {
        return $this->hasOne(Accs::className(), ['vpnid' => 'id'])->joinWith('profil');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя VPN',
            'value' => 'Пароль VPN',
            'status' => 'Статус',
            'untildate' => 'Дейстует до',
            'datecreate' => 'Дата создания',
            'email' => 'Email (доступа к сайту)',
            'pass' => 'Пароль (доступа к сайту)',
            'phone' => 'Телефон',
            'tariff' => 'Тариф',
            'role' => 'Роль',
            'comment' => 'Комментарий',
            'expire' => 'Дней до окончании подписки',
        ];
    }

    public function check()
    {
        $acc = Accs::find()->where(['email' => $this->email])->all();
        if (!$this->id && !empty($acc)) {
            $this->addError('email', 'email duplicate');
            return false;
        }
        return true;
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

}
