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

    <?= $form->field($model, 'period')->dropDownList(['7' => 'на 7 дней', '30' => '30 дней', '180' => '180 дней', '365' => '365 дней']) ?>

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
