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

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php if (!empty($accs->vpn)): ?>
                    <div>
                        <div class="row">
                            <label style="text-align: right" class="col-lg-3 control-label">Vpn login: </label>
                            <div class="col-lg-9"><?= $accs->vpn->username ?></div>
                        </div>
                        <div class="row">
                            <label style="text-align: right" class="col-lg-3 control-label">Vpn password: </label>
                            <div class="col-lg-9"> <?= $accs->vpn->value ?></div>
                        </div>
                        <div class="row">
                            <label style="text-align: right" class="col-lg-3 control-label">Тариф: </label>
                            <div class="col-lg-9"> <?= $accs->tariff ?></div>
                        </div>
                        <div class="row">
                            <label style="text-align: right" class="col-lg-3 control-label">Дейстует до: </label>
                            <div class="col-lg-9"> <?= date("d.m.Y", $accs->untildate) ?></div>
                        </div>
                        <div class="row">
                            <label style="text-align: right" class="col-lg-3 control-label">
                                <?= Html::a('Купить', ['/tariff'], ['class' => 'btn  btn-success']) ?>
                            </label>
                            <?= Html::a('Продлить', ['/tariff'], ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label style="text-align: right" class="col-lg-3 control-label"> Реферальная ссылка: </label>
                    </div>

                <?php endif; ?>
                <hr>
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

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'new_password')->passwordInput() ?>

                <hr/>

                <?= $form->field($model, 'current_password')->passwordInput() ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php if ($model->module->enableAccountDelete): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
                </div>
                <div class="panel-body">
                    <p>
                        <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                        <?= Yii::t('user', 'It will be deleted forever') ?>.
                        <?= Yii::t('user', 'Please be certain') ?>.
                    </p>
                    <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                        'class' => 'btn btn-danger',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
                    ]) ?>
                </div>
            </div>
        <?php endif ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Партнерская программа</h3>
            </div>
            <div class="panel-body">
                <p>
                    Поделитесь промо-ссылкой с Вашими друзьями <a href="<?= "https://" . $domain . "?ref=" . ($accs->promocode ?? '') ?>" target="_blank" ><?= "https://" . $domain . "?ref=" . ($accs->promocode ?? '') ?></a>
                    За каждого кто зарегистрируется и оплатит подписку, Вы получите неделю использования VPN в подарок
                    (там показывать промокод юзера персональный)
                </p>
            </div>
        </div>
    </div>
</div>
