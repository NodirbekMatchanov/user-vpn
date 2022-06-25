<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TelegramManagers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="telegram-managers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'chat_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
