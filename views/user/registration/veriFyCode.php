<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Подтверждения код активации';

?>
<div class="container">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3" style="padding: 100px 300px">
        <h3>Подтверждения код активации</h3>
            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
            ]); ?>


        <div class="input-2" style="margin: 15px">
            <label for="" class="input-2-label">Код</label>
            <?= $form->field($verifyCode, 'code')->label(false) ?>
        </div>
        <?= Html::submitButton('Активировать', ['class' => 'btn-2 _outline','style' => 'margin:auto']) ?>

            <?php ActiveForm::end(); ?>

        </div>
</div>
