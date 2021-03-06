<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Promocodes */
/* @var $form yii\widgets\ActiveForm */
$model->author = Yii::$app->user->identity->getId();
?>

<div class="promocodes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'promocode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_start')->widget(\kartik\date\DatePicker::className(),[
        'model' => $model,
        'attribute' => 'expire',
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>
    <?= $form->field($model, 'expire')->widget(\kartik\date\DatePicker::className(),[
        'model' => $model,
        'attribute' => 'expire',
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>

    <a href="#" id="7days">7 дней</a> |
    <a href="#" id="30days">30 дней</a> |
    <a href="#" id="90days">90 дней</a> |
    <a href="#" id="365days">365 дней</a> |

    <?= $form->field($model, 'user_limit')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([\app\models\Tariff::ACTIVE => 'активен',\app\models\Tariff::ARCHIVE => 'не активен']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'free_day')->textInput() ?>

    <?= $form->field($model, 'freeday_partner')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true,'value' => Yii::$app->user->identity->getId()])->hiddenInput() ?>

    <?php $format = new \yii\web\JsExpression(
        "function format(data) {
                                if(data.text != 'выбрать страну') {
                                return  data.text + ' <i ><img src=/web/flags_ru/'+ data.text.replaceAll(' ','_') +'.png></i>'
                                } else {
                                  return  data.text 
                                }
                                ;
                            }"
    ); ?>
    <?=
    $form->field($model, 'country')->widget(\kartik\select2\Select2::classname(), [
        'data' => \app\models\Country::getAll(),
        'options' => ['placeholder' => 'выбрать страну'],
        'pluginOptions' => [
            'escapeMarkup' => new \yii\web\JsExpression("function(m) { return m; }"),
            'templateResult' => $format,
            'templateSelection' => $format,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]) ?>
    <?= $form->field($model, 'tariffs')->widget(\kartik\select2\Select2::className(),[
        'maintainOrder' => true,
        'data' => \app\models\Tariff::getAllList(),
        'options' => ['placeholder' => 'Привязка к тарифам ...', 'multiple' => true],
        'pluginOptions' => [
            'maximumInputLength' => 10
        ],
    ]) ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\select2\Select2::className(),[
        'maintainOrder' => true,
        'data' => \app\models\user\User::getUserList(),
        'options' => ['placeholder' => 'Привязка к пользователям ...', 'multiple' => false],
        'pluginOptions' => [
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
