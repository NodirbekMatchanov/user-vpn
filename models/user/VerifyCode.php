<?php

namespace app\models\user;

use app\models\Accs;
use app\modules\api\v1\models\Users;
use app\modules\api\v1\models\VpnUserSettings;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "vpn_ips".
 *
 * @property int $email
 * @property string|null $code
 */
class VerifyCode extends Model
{
    public $code;
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code','email'], 'required'],
            [['code','email'], 'string', 'max' => 255],
            [['code'], 'check'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'email',
            'code' => 'Код активации',
        ];
    }

    function check() {
        $user = Accs::find()->where(['email' => $this->email, 'verifyCode' => $this->code])->one();
        if(empty($user)){
           $this->addError('code','Не корректный код');
            return false;
        }
        $user->status = VpnUserSettings::$statuses['ACTIVE'];
        $user->untildate = strtotime('+ 3 days');
        $user->save();

        return true;
    }

}
