<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Translations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="translations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device')->dropDownList(['web' => 'web', 'ios' => 'ios', 'android' => 'android']) ?>

    <?= $form->field($model, 'page')->dropDownList([
        'sign' => 'авторизация',
        'login' => 'регистрация',
        'home' => 'основной экран',
        'menu' => 'меню',
        'vpn-ips' => 'сервера',
        'dns-servers' => 'днс',
        'profile' => 'профиль',
        'support' => 'поддержка'
    ]) ?>

    <?= $form->field($model, 'element_type')->dropDownList([
        'заголовок' => 'заголовок',
        'подзаголовок' => 'подзаголовок',
        'текст' => 'текст',
        'кнопка' => 'кнопка',
        'меню' => 'меню'
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'country')->dropDownList(\app\models\Country::getAll()) ?>

    <?= $form->field($model, 'date')->textInput(['value' => date("Y-m-d")]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
