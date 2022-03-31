<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VpnIpsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vpn-ips-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ip') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'city') ?>
    <?= $form->field($model, 'host') ?>
    <?= $form->field($model, 'login') ?>
    <?= $form->field($model, 'password') ?>
    <?= $form->field($model, 'expire') ?>

    <?php // echo $form->field($model, 'cert') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
