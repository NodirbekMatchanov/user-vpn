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


        <div class="input-2">
            <label for="" class="input-2-label">Code</label>
            <?= $form->field($verifyCode, 'code')->label(false) ?>
        </div>
        <?= Html::submitButton('Активировать', ['class' => 'btn-2 _outline']) ?>

            <?php ActiveForm::end(); ?>

        </div>
</div>
