<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Support */
/* @var $form yii\widgets\ActiveForm */

if(!empty($model->tags)){
    $model->tagsList = explode(',', $model->tags);
}
?>

<div class="support-form">

    <?php $form = ActiveForm::begin(); ?>


    <?=$form->field($model, 'question')->textInput()?>
 <?= $form->field($model, 'answer')->widget(\kartik\editors\Summernote::class, [
        'useKrajeePresets' => true,
        // other widget settings
    ]);
    ?>



    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'category')->textInput() ?>

    <?= $form->field($model, 'tagsList')->widget(\kartik\select2\Select2::className(),[
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
