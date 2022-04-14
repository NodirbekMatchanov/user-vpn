<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['text' => 'text', 'file' => 'file']) ?>

    <?php if (Yii::$app->controller->action->id == 'update'): ?>

        <?php if ($model->type == 'file'): ?>
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
        <?php endif; ?>
        <?php if ($model->type == 'text'): ?>
            <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
