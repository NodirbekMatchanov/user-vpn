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
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */
$domain = (\app\models\VpnIps::getSettings()['domain'] ?? 'vpn-max.com');
$this->title = Yii::t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;
?>


<br>
<style>
    .form-group {
        width: 100%;
    }
</style>
<div class="settings">
    <div class="container">
        <h3 class="title-3">Имя пользователя OpenVPN / IKEv2</h3>

        <div class="settings-text">
            Используйте следующие учетные данные для подключения к VPN MAX через сторонние <br>
            приложения, например, Tunnelblick на MacOS или OpenVPN на GNU/Linux.
        </div>

        <div class="settings-text">
            Do not use the OpenVPN / IKEv2 credentials in VPN MAX applications or on the VPN MAX <br>
            dashboard. Узнать больше
        </div>
        <?php if (!empty($accs->vpn)): ?>
            <div class="info">
                <div class="info-row">
                    <div class="info-col">Имя пользователя OpenVPN / IKEv2</div>
                    <div class="info-col">
                        <div class="info-wrap">
                            <div class="info-value"><?= $accs->vpn->username ?></div>
                            <div class="info-actions">
                                <div class="info-btn" data-copy="<?= $accs->vpn->username ?>">
                                    <div class="copy-text">Успешно скопировано</div>
                                    <img src="/web/img/icons/copy.svg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-col">Пароль OpenVPN / IKEv2</div>
                    <div class="info-col">
                        <div class="info-wrap">
                            <div class="info-value _password" data-value='<?= $accs->vpn->value ?>'><?= $accs->vpn->value ?></div>
                            <div class="info-actions">
                                <div class="info-btn" data-copy="<?= $accs->vpn->value ?>">
                                    <div class="copy-text">Успешно скопировано</div>
                                    <img src="/web/img/icons/copy.svg">
                                </div>
                                <div class="info-btn _show-pass"><img src="/web/img/icons/eye.svg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <button class="btn-2">Сбросить учетные данные</button>

    </div>
</div>


<div class="settings">
    <div class="container">
        <h3 class="title-3">Настройки аккаунта</h3>

        <div class="settings-block">
            <div class="settings-block-row">
                <div class="settings-block-label">Vpn login:</div>
                <div class="settings-block-value"><?= $accs->vpn->username ?></div>
            </div>

            <div class="settings-block-row">
                <div class="settings-block-label">Vpn password:</div>
                <div class="settings-block-value"><?= $accs->vpn->value ?></div>
            </div>

            <div class="settings-block-row">
                <div class="settings-block-label">Тариф:</div>
                <div class="settings-block-value"><?= $accs->tariff ?></div>
            </div>

            <div class="settings-block-row">
                <div class="settings-block-label">Дейстует до:</div>
                <div class="settings-block-value"><?= date("d.m.Y", $accs->untildate) ?></div>
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'account-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]); ?>

        <div class="settings-block">
            <div class="settings-block-row">
                <div class="settings-block-label">Email</div>
                <div class="settings-block-value">
                    <div class="input-2">
                        <?= $form->field($model, 'email')->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="settings-block-row">
                <div class="settings-block-label">Имя пользователя</div>
                <div class="settings-block-value">
                    <div class="input-2">
                        <?= $form->field($model, 'username')->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="settings-block-row">
                <div class="settings-block-label">Новый пароль</div>
                <div class="settings-block-value">
                    <div class="input-2">
                        <?= $form->field($model, 'new_password')->passwordInput()->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="settings-block-row">
                <div class="settings-block-label">Текущий пароль</div>
                <div class="settings-block-value">
                    <div class="input-2">
                        <?= $form->field($model, 'current_password')->passwordInput()->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="settings-block-row">
                <div class="settings-block-label"></div>
                <div class="settings-block-value">
                    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn-2']) ?><br>

                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>


<div class="settings">
    <div class="container">
        <h3 class="title-3">Восстановление</h3>

        <div class="settings-text">
            В случае, если вы потеряете информацию для входа, мы отправим вам инструкцию<br>
            на электронную почту
        </div>

        <div class="settings-email">
            <div class="settings-email-title">
                Электронная почта<br>
                для восстановления
            </div>
            <div class="settings-email-content">
                <form class="settings-email-form">
                    <div class="input-2">
                        <input type="email" name='email' checked>
                    </div>
                    <button class="btn-2" disabled>Сохранить</button>
                </form>
                <div class="settings-email-status">
                    <span class='settings-email-thumb'></span>
                    <span>Разрешить восстановление по эл. почте</span>
                </div>

                <div class="switch-wrap">
                    <label  class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>

                    <div class="switch-text">Разрешить восстановление по эл. почте</div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="settings">
    <div class="container">
        <h3 class="title-3">Подписки на рассылки</h3>

        <div class="settings-text">
            Чтобы быть в курсе последних разработок продуктов Proton, вы можете подписаться<br>
            на наши различные рассылки и время от времени посещать наш блог
        </div>

        <div class="switch-wrap">
            <label  class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>

            <div class="switch-text">Объявления компании VPN MAX (1 письмо в квартал)</div>
        </div>

        <div class="switch-wrap">
            <label  class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>

            <div class="switch-text">Объявления о продукте VPN MAX (1-2 письма в месяц)</div>
        </div>

        <div class="switch-wrap">
            <label  class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>

            <div class="switch-text">Новостная рассылка VPN MAX для бизнеса (1 письмо в месяц)</div>
        </div>

        <div class="switch-wrap">
            <label  class="switch">
                <input type="checkbox" checked>
                <span class="slider round"></span>
            </label>

            <div class="switch-text">Новостная рассылка VPN MAX (1 письмо в месяц)</div>
        </div>

        <div class="switch-wrap">
            <label  class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>

            <div class="switch-text">Объявления о VPN MAX beta (1-2 письма в месяц)</div>
        </div>

        <div class="switch-wrap">
            <label  class="switch">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>

            <div class="switch-text">Предложения и акции VPN MAX (1 письмо в квартал)</div>
        </div>

    </div>
</div>


<div class="settings">
    <div class="container">
        <h3 class="title-3">Удалить</h3>

        <div class="settings-text">
            Это навсегда удалит ваш аккаунт и все его данные. Вы не сможете восстановить<br>
            эту учетную запись.
        </div>
        <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
            'class' => 'btn-2 _outline _danger',
            'data-method' => 'post',
            'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
        ]) ?>

    </div>
</div>
<div class="settings">
    <div class="container">
        <h3 class="panel-title">Партнерская программа</h3>
        <div class="settings-text">
            Поделитесь промо-ссылкой с Вашими друзьями <a href="<?= "https://" . $domain . "?ref=" . ($accs->promocode ?? '') ?>" target="_blank" ><?= "https://" . $domain . "?ref=" . ($accs->promocode ?? '') ?></a>
            За каждого кто зарегистрируется и оплатит подписку, Вы получите неделю использования VPN в подарок
        </div>
        <p>Вашей рекомендации зарегистировалось <?=$registratedCount?> человек из них купили подскику <?=$payoutCount?> </p>

    </div>
</div>
