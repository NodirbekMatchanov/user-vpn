<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\models\user\User;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\VpnUserSettings */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="vpn-user-settings-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pass')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList(\app\models\VpnUserSettings::$statuses) ?>
    <?= $form->field($model, 'tariff')->dropDownList(\app\models\VpnUserSettings::$tariffs) ?>

    <?= $form->field($model, 'untildate')->widget(\kartik\datetime\DateTimePicker::className(),[
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]) ?>
    <?= $form->field($model, 'role')->dropDownList(\app\models\VpnUserSettings::$roles) ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    <?= $form->field($model, 'comment')->textarea() ?>
    <?= $form->field($model, 'country')->dropDownList(array_merge(['' => ''],\app\models\Country::getAll())) ?>

    <?= $form->field($model, 'test_user')->checkbox() ?>
    <?= $form->field($model, 'background_work')->checkbox() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
