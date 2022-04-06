<?php

namespace app\models;

use app\modules\api\v1\models\Users;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "vpn_ips".
 *
 * @property int $id
 * @property string $ip
 * @property string $status
 * @property string|null $country
 * @property string|null $city
 * @property string|null $cert
 * @property string|null $host
* @property string|null $login
* @property string|null $password
* @property string|null $expire
*/
class VpnIps extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vpn_ips';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'status'], 'required'],
            [['expire'], 'safe'],
            [['load_serv'], 'integer','max' => 100, 'min' => 0],
            [['ip', 'cert', 'host', 'login', 'password'], 'string', 'max' => 255],
            [['file'], 'safe'],
            [['file'], 'file'],
            [['file'], 'file', 'maxSize' => '20000000'],
            [['status', 'country', 'city'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ип',
            'status' => 'Статус',
            'country' => 'Страна',
            'city' => 'Город',
            'cert' => 'Сертификат',
            'host' => 'Хостинг',
            'login' => 'Логин',
            'password' => 'Пароль',
            'expire' => 'Действует до',
            'file' => 'Файл сертификата',
            'load_serv' => 'Нагрузка %',
            'la' => 'Нагрузка %',
            'desc' => 'Описание',
        ];
    }

    public function beforeSave($insert)
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if (!empty($this->file)) {
            $fileName = $this->ip . '.' . $this->file->extension;
            if (!is_dir(Yii::getAlias('@app') . '/web/certs/')) {
                mkdir(Yii::getAlias('@app') . '/web/certs/');
            }
            $this->file->saveAs(Yii::getAlias('@app') . '/web/certs/' . $fileName);
            $this->cert = $fileName;
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public static function getVpnServerList(){
        $data = null;
        $request = json_decode(Yii::$app->request->getRawBody(),true);
        $user = new Users();
        if($user->load($request,"") && $user->login()) {
            $vpnIps = VpnIps::find()->orderBy('id desc')->all();
        }  else {
            $vpnIps = VpnIps::find()->orderBy('id desc')->limit(5)->all();
        }

        if(!empty($vpnIps)){
           foreach($vpnIps as $server) {
               $data[] = [
                   'country' => $server->country,
                   'city' => $server->city,
                   'ip' => $server->ip,
                   'cert' => 'https://www.vpnmax.org/web/certs/' .$server->cert,
                   'load' => $server->load_serv,
               ];
           }
        }
        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServerLoad()
    {
        return $this->hasOne(Serverload::className(), ['ipaddr' => 'ip']);
    }
}