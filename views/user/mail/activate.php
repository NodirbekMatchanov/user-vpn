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
$template = \app\models\MailTemplate::find()->where(['tmp_key' => 'activate'])->one();

?>
<?php if(empty($template)): ?>

<p>Здравствуйте, Ваш аккаунт успешно активирован.</p>
<p>Впнлогином: <?=$user->email?></p>
<p>Пароль : <?=$user->pass?></p>
<?php else:
    $templateStr = str_replace('$email',$user->email,$template->body);
    $templateStr = str_replace('$pass',$user->pass,$templateStr);
    ?>
    <?= $templateStr?>
<?php endif;?>