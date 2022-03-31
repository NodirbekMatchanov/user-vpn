<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MailTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->widget(\kartik\editors\Summernote::class, [
        'useKrajeePresets' => true,
        // other widget settings
    ]);
    ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
