<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php if ($module->enableFlashMessages): ?>
    <div class="row">
        <div class="col-xs-12">
            <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
                <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
                    <?= \app\widgets\Alert::widget([
                        'options' => ['class' => 'alert-dismissible alert-' . $type],
                        'body' => $message
                    ]) ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>
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
