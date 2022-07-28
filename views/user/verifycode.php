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
 * @var string $verifyCode
 */
$template = \app\models\MailTemplate::find()->where(['tmp_key' => 'verifycode'])->one();

?>
<?php if(empty($template)): ?>

<p>Код активации <?=$verifyCode?></p>
<?php else:
    $templateStr = str_replace('$code',$verifyCode,$template->body);
?>
    <?= $templateStr?>
<?php endif;?>