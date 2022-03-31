<?php

namespace app\models\user;

use dektrium\user\helpers\Password;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\Application as WebApplication;

class User extends \dektrium\user\models\User
{

    public const NOACTIVE = 0;
    public const ACTIVE = 1;
    public const EXPIRE = 3;
    public const DELETED = 4;


}
