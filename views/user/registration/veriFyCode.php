<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">

    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <h3>Подтверждения код активации</h3>
            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
            ]); ?>

            <?= $form->field($verifyCode, 'email') ?>
            <?= $form->field($verifyCode, 'code') ?>
        <?= Html::submitButton('Подтвердит', ['class' => 'btn btn-success btn-block']) ?>

            <?php ActiveForm::end(); ?>

        </div>
</div>
