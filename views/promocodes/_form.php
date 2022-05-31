<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Promocodes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promocodes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'promocode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_start')->widget(\kartik\date\DatePicker::className(),[
        'model' => $model,
        'attribute' => 'expire',
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>
    <?= $form->field($model, 'expire')->widget(\kartik\date\DatePicker::className(),[
        'model' => $model,
        'attribute' => 'expire',
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>
    <?= $form->field($model, 'user_limit')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([\app\models\Tariff::ACTIVE => 'активен',\app\models\Tariff::ARCHIVE => 'не активен']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'free_day')->textInput() ?>

    <?= $form->field($model, 'freeday_partner')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->dropDownList(\app\models\Country::getAll()) ?>

    <?= $form->field($model, 'tariffs')->widget(\kartik\select2\Select2::className(),[
        'maintainOrder' => true,
        'data' => \app\models\Tariff::getAllList(),
        'options' => ['placeholder' => 'Привязка к тарифам ...', 'multiple' => true],
        'pluginOptions' => [
            'maximumInputLength' => 10
        ],
    ]) ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\select2\Select2::className(),[
        'maintainOrder' => true,
        'data' => \app\models\user\User::getUserList(),
        'options' => ['placeholder' => 'Привязка к пользователям ...', 'multiple' => false],
        'pluginOptions' => [
            'maximumInputLength' => 10
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
