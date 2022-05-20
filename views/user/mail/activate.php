<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var dektrium\user\Module $module
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Token $token
 * @var bool $showPassword
 */

?>
<p>Здравствуйте, Ваш аккаунт успешно активирован.</p>
<p>Впнлогином: <?=$user->email?></p>
<p>Пароль : <?=$user->pass?></p>
