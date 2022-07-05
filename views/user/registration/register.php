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
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .form-group {
        width: 100%;
    }
</style>
<?php $form = ActiveForm::begin([
    'id' => 'registration-form',
    'options' => ['class' => 'form-content'],
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
]); ?>
<h3><?= Html::encode($this->title) ?></h3>

<div class="input-2">
    <label for="" class="input-2-label">E-mail</label>
    <?= $form->field($model, 'email')->label(false) ?>
</div>

<div class="input-2">
    <label for="" class="input-2-label">Телефон</label>
    <?= $form->field($model, 'phone')->label(false) ?>
</div>

<div class="input-2">
    <label for="" class="input-2-label">Промокод</label>
    <?= $form->field($model, 'promocode')->textInput(['value' => (Yii::$app->request->get('ref'))])->label(false) ?>
    <div style="margin-top: 10px;  margin-bottom: 5px;" class="valid-promocode">

    </div>
</div>
<?= $form->field($model, 'utm_source')->textInput(['value' => Yii::$app->request->get('utm_source')])->hiddenInput()->label(false) ?>
<?= $form->field($model, 'utm_term')->textInput(['value' => Yii::$app->request->get('utm_term')])->hiddenInput()->label(false) ?>
<?= $form->field($model, 'utm_campaign')->textInput(['value' => Yii::$app->request->get('utm_campaign')])->hiddenInput()->label(false) ?>
<?= $form->field($model, 'utm_medium')->textInput(['value' => Yii::$app->request->get('utm_medium')])->hiddenInput()->label(false) ?>


<div class="input-2">
    <label for="" class="input-2-label">Пароль</label>
    <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
</div>

<div class="input-2">
    <label for="" class="input-2-label">Подтвердить</label>
    <?= $form->field($model, 'password_repeat')->passwordInput()->label(false) ?>
</div>

<div class="form-buttons">
    <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn-2']) ?>
    <a href='<?= \yii\helpers\Url::to(["/site/login"]) ?>' class="btn-2 _outline">Авторизоваться</a>
</div>
<br>

<p class="text-center">
    <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
    <br>
    <?= Html::a(
        Yii::t('user', 'Forgot password?'),
        ['/user/recovery/request'],
        ['tabindex' => '5']
    ) ?>
</p>
<?php ActiveForm::end(); ?>

