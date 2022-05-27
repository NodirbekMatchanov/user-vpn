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
$day = 0;
?>
<?php if(empty($template)): ?>

<p>Здравствуйте, Ваша Premium подписка закончилась</p>
<?php else:
    $templateStr = str_replace('$day',$day,$template->body);
    ?>
    <?= $templateStr?>
<?php endif;?>