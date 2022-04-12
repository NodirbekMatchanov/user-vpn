<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PromocodesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promocodes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'promocode') ?>

    <?= $form->field($model, 'expire') ?>

    <?= $form->field($model, 'user_limit') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'free_day') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
