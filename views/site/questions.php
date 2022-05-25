<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questions */
/* @var $form ActiveForm */
?>
<div class="site-questions">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'text') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'name') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-questions -->
