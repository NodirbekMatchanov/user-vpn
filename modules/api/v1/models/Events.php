<?php

namespace app\modules\api\v1\models;

use app\components\DateFormat;
use app\models\Accs;
use app\models\MailHistory;
use app\models\user\Profile;
use app\models\user\LoginForm;
use app\models\UserEvents;
use http\Message;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\modules\api\v1\models\VpnUserSettings;
use dektrium\user\models\User;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;

class Events extends Model
{

    public $datetime ;
    public $userId ;
    public $event ;
    public $text ;

    public function rules()
    {
        return [
            [['datetime'], 'safe'],
            [['userId', 'event'], 'required'],
            [['userId'], 'integer'],
            [['text'], 'string'],
            [['event'], 'string', 'max' => 255],
        ];
    }

    public function Add(){
        $events = new UserEvents();
        $events->datetime = $this->datetime ?? date("Y-m-d H:i:s");
        $events->user_id = $this->userId;
        $events->event = (string)$this->event;
        $events->text = $this->text;
        if($events->save()) {
            return true;
        }
        return $events->errors;
    }


}
