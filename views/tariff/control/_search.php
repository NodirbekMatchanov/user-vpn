<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TariffSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tariff-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'period') ?>

    <?= $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'expire') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
