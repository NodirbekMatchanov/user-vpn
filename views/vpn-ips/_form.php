<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VpnIps */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="vpn-ips-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(\app\models\VpnUserSettings::$statuses) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'load_serv')->textInput(['maxlength' => true,'type' => "number",'max' => 100, 'min' => 0]) ?>

    <?= $form->field($model, 'expire')->widget(\kartik\date\DatePicker::className(),[
        'model' => $model,
        'attribute' => 'expire',
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>
    <?=
    $form->field($model, 'file')->widget(\kartik\file\FileInput::className(), [
        'language' => 'ru',
        'pluginOptions' => [
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ],
        'options' => ['multiple' => false],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
