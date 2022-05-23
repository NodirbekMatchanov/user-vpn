<?php
namespace app\models;

use Yii;
use yii\base\Model;


class PushTestForm extends Model
{
    public $fcm_token = "";
    public $ios_token = "";
    public $title     = "";
    public $body      = "";

    public function rules()
    {
        return [
           [ 'title', 'required', 'message' => 'Заголовок сообщения не может быть пустым' ],
           [ 'body',  'required', 'message' => 'Тело сообщения не может быть пустым' ],
           [ 'fcm_token', 'required', 
             'when' => function ($model) { return empty($model->ios_token); },
             'whenClient' => "function(a,v) { return $('#ios_token').val() == '' }",
             'message' => 'Необходимо указать хотя бы один токен',
           ],
           [ 'ios_token', 'required', 
             'when' => function ($model) { return empty($model->fcm_token); },
             'whenClient' => "function(a,v) { return $('#fcm_token').val() == '' }",
             'message' => 'Необходимо указать хотя бы один токен',
           ],
        ];
    }

    public function attributeLabels()
    {
        return [ 
           'title' => 'Заголовок',
           'body'  => 'Сообщение',
           'fcm_token' => 'Токен Android',
           'ios_token' => 'Токен iOS',
        ];
    }
}
