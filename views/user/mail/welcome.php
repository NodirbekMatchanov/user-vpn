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
$template = \app\models\MailTemplate::find()->where(['tmp_key' => 'welcome'])->one();
$accs = \app\models\Accs::find()->where(['email' => $user->email])->one();

?>
<?php if ($user->module->enableConfirmation == false): ?>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Yii::t('user', 'Hello') ?>,
    </p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
        <?= Yii::t('user', 'Your account on {0} has been created', Yii::$app->name) ?>.
        <?php if ($showPassword || $module->enableGeneratingPassword): ?>
            <?= Yii::t('user', 'We have generated a password for you') ?>: <strong><?= $user->password ?></strong>
        <?php endif ?>

    </p>
<?php else: ?>

    <?php if (empty($template)): ?>
        <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
            <?= Yii::t('user', 'Hello') ?>,
        </p>

        <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
            <?= Yii::t('user', 'Your account on {0} has been created', Yii::$app->name) ?>.
            <?php if ($showPassword || $module->enableGeneratingPassword): ?>
                <?= Yii::t('user', 'We have generated a password for you') ?>: <strong><?= $user->password ?></strong>
            <?php endif ?>

        </p>

        <?php if ($token !== null): ?>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                <?= Yii::t('user', 'In order to complete your registration, please click the link below') ?>.
            </p>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                <?= Html::a(Html::encode($token->url), $token->url); ?>
            </p>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                ?????? ??????????????????: <?= $verifyCode ?>
            </p>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                <?= Yii::t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.
            </p>
        <?php endif ?>

        <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
            <?= Yii::t('user', 'If you did not make this request you can ignore this email') ?>.
        </p>
    <?php else:
        $templateStr = str_replace('$verifyCode', $verifyCode, $template->body);
        $templateStr = str_replace('$url', Html::a(Html::encode($token->url), $token->url), $templateStr);
        $templateStr = str_replace('$username', $user->email, $templateStr);
        ?>

        <?= $templateStr ?>
    <?php endif; ?>

<?php endif; ?>