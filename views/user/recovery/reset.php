<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Reset your password');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .form-group {
        width: 100%;
    }
</style>

<div class="container">
    <?php $form = ActiveForm::begin([
        'id' => 'password-recovery-form',
        'options' => ['class' => 'form-content'],
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
    ]); ?>

    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

    <div class="input-2">
        <label for="" class="input-2-label">Новый пароль</label>
        <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
    </div>
    <div class="input-2">
        <label for="" class="input-2-label">Повторный пароль</label>
        <?= $form->field($model, 'password_repeat')->passwordInput()->label(false) ?>
    </div>

    <?= Html::submitButton(Yii::t('user', 'Finish'), ['class' => 'btn btn-success btn-block']) ?><br>

    <?php ActiveForm::end(); ?>
</div>
