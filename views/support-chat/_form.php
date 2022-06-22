<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupportChat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="support-chat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'chatId')->textInput() ?>

    <?= $form->field($model, 'managerId')->textInput() ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'is_new')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
