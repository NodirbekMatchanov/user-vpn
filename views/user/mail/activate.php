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
<?php if (empty($template)): ?>
    <div class="content"  style="box-sizing: border-box; font-size: 26px; max-width: 100%; outline: none; padding: 45px 50px 70px;">
        <h2>Здравствуйте,</h2>
        <p>Ваш аккаунт успешно активирован.</p>
        <p>Впнлогином: <?= $user->email ?></p>
        <p>Пароль : <?= $user->pass ?></p>
    </div>
<?php else:
    $templateStr = str_replace('$email', $user->email, $template->body);
    $templateStr = str_replace('$pass', $user->tmp_pass, $templateStr);
    ?>
    <?= $templateStr ?>
<?php endif; ?>