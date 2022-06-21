<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .form-group {
        width: 100%;
    }
</style>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="form">
    <div class="container">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-content'],
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
            ]) ?>
            <h1 class="title-3">Авторизоваться</h1>

            <div class="input-2">
                <label for="" class="input-2-label">E-mail</label>
                <?= $form->field($model, 'login',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'input-2','style' => 'width:100%', 'tabindex' => '1']]
                )->label(false);
                ?>
            </div>

            <div class="input-2">
                <label for="" class="input-2-label">Пароль</label>
                <?= $form->field(
                    $model,
                    'password',
                    ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
                    ->passwordInput()
                    ->label(false
                    ) ?>
            </div>

            <label class="checkbox">
                <input type="checkbox" name="rememberMe" hidden>
                <span class="checkbox-content">
					<span class="checkbox-thumb"></span>
					<span class="checkbox-text">Запомнить меня</span>
				</span>
            </label>


            <div class="form-buttons">
                <?= Html::submitButton(
                    Yii::t('user', 'Sign in'),
                    ['class' => 'btn-2', 'tabindex' => '4']
                ) ?>
                <?=($module->enablePasswordRecovery ?
                    Html::a(
                        Yii::t('user', 'Forgot password?'),
                        ['/user/recovery/request'],
                        ['tabindex' => '5','class' => 'form-link']
                    )
                    : '')?>
                <a href='<?=\yii\helpers\Url::to(["/user/register"])?>' class="form-link">Зарегистрироваться</a>
            </div>
            <?php ActiveForm::end(); ?>
    </div>
</div>
