<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tariff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tariff-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([\app\models\Tariff::ACTIVE => 'активен',\app\models\Tariff::ARCHIVE => 'архивный']) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'price_7')->textInput() ?>
    <?= $form->field($model, 'day_7')->checkbox() ?>

    <?= $form->field($model, 'price_30')->textInput() ?>
    <?= $form->field($model, 'day_30')->checkbox() ?>

    <?= $form->field($model, 'price_180')->textInput() ?>
    <?= $form->field($model, 'day_180')->checkbox() ?>

    <?= $form->field($model, 'price_365')->textInput() ?>
    <?= $form->field($model, 'day_365')->checkbox() ?>



    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expire')->widget(\kartik\date\DatePicker::className(),[
        'model' => $model,
        'attribute' => 'expire',
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
