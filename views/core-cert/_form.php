<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CoreCert */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="core-cert-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=     $form->field($model, 'file_core')->widget(\kartik\file\FileInput::className(), [
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
