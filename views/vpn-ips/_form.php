<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\models\VpnIps;
/* @var $this yii\web\View */
/* @var $model app\models\VpnIps */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(
    '@web/js/jquery.input.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/repeater.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>

<div class="vpn-ips-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provider')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(\app\models\VpnUserSettings::$statuses) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(\app\models\VpnUserSettings::$types) ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expire')->widget(\kartik\date\DatePicker::className(),[
        'model' => $model,
        'attribute' => 'expire',
        'type' => \kartik\date\DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>



    <label class=" " style="display: block; margin-bottom: 15px">Файл сертификата:</label>
    <div class="panel panel-default">
    <div class="panel-body">
        <div id="kt_repeater_1">
            <div class="form-group row">
                <div data-repeater-list="data" class="col-lg-10">
                    <div data-repeater-item="" class="form-group " style="">
                        <?= $form->field($model, 'certType')->dropDownList([VpnIps::CERT_IKEV => VpnIps::CERT_IKEV, VpnIps::CERT_OPVPN => VpnIps::CERT_OPVPN]) ?>
                        <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                        <div class=" form-group" >
                            <a href="javascript:;" data-repeater-delete=""
                               class="btn btn-sm font-weight-bolder btn-danger">
                                <i class="la la-trash-o"></i>Удалить</a>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <a href="javascript:;" data-repeater-create=""
                       class="btn btn-sm font-weight-bolder btn-primary">
                        <i class="la la-plus"></i>Добавить </a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
