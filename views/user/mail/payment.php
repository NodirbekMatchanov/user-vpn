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
 * @var int $expireDay
 * @var string $expireDate
 */
$template = \app\models\MailTemplate::find()->where(['tmp_key' => 'payment'])->one();

?>
<?php if (empty($template)): ?>
    <div class="content"
         style="box-sizing: border-box; font-size: 26px; max-width: 100%; outline: none; padding: 45px 50px 70px;">
        <h2>Здравствуйте,</h2>
        <p>у вас активирован Premium тариф со сроком <?= $expireDay ?> дней до <?= $expireDate ?></p>
    </div>
<?php else:
    $templateStr = str_replace('$expireDay', $expireDay, $template->body);
    $templateStr = str_replace('$expireDate', $expireDate, $templateStr);
    ?>
    <?= $templateStr ?>
<?php endif; ?>