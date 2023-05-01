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
$registrationUsers = \app\models\RegistrationUsers::find()->where(['email' => $accs->email])->one();
?>
<?php if (!empty($registrationUsers)):
    $template = \app\models\MailTemplate::find()->where(['tmp_key' => 'welcome_without_code'])->one();
    ?>
    <?php if (!empty($template)) : ?>
        <?= $template->body ?>
    <?php else: ?>
    <div class="content" style="box-sizing: border-box; font-size: 26px; max-width: 100%; outline: none; padding: 45px 50px 70px;">
        <h2>Здравствуйте,</h2>

        <p>Ваш аккаунт на сайте &laquo;VPN MAX&raquo; был успешно создан.</p>

        <a href="https://vpnmax.onelink.me/LdpN/chckzqmm">Наше приложение для iOS </a>

        <p>P.S. Если вы получили это сообщение по ошибке, просто удалите его.</p>
    </div>

<?php endif; ?>
<?php else : ?>
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
                    <?= Yii::t('user', 'We have generated a password for you') ?>:
                    <strong><?= $user->password ?></strong>
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
                    Код активации: <?= $verifyCode ?>
                </p>
                <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                    <?= Yii::t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>
                    .
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
<?php endif; ?>
