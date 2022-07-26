<?php

namespace app\models\user;

use app\models\Accs;
use app\models\RegistrationUsers;
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
    public $user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
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
        $this->user = RegistrationUsers::find()->where([ 'verifyCode' => $this->code])->one();
        if(empty($this->user)){
           $this->addError('code','Не корректный код');
            return false;
        }
        return true;
    }

}
