<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupportChatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="support-chat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'chatId') ?>

    <?= $form->field($model, 'managerId') ?>

    <?= $form->field($model, 'message') ?>

    <?= $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'is_new') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
