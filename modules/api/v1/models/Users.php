<?php

namespace app\modules\api\v1\models;

use app\components\DateFormat;
use http\Message;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\helpers\Json;

class Users extends Model
{

    public function rules()
    {
        return [
            [['avtoNumber'], 'required'],
            ['avtoNumber', 'match', 'pattern' => '/^[а-яА-Я]{1}\s?[0-9]{3}\s?[а-яА-Я]{2}\s?[0-9]{2,3}$/ui', 'message' => 'Введите гос номер автомобиля на русском без пробелов'],
        ];
    }

    public function getStatus()
    {

    }

    public function errorResponse()
    {
        throw new \yii\web\HttpException(500, 'API не доступен');
    }

    public function notFoundPassResponse()
    {
        throw new \yii\web\HttpException(404, 'Пропуск не найден');
    }


}
