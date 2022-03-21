<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
use \app\models\user\User;
/**
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $user
 */
?>

<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
<?= $form->field($user, 'vpnlogin')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'vpnpassword')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'until')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'status')->dropDownList([User::ACTIVE => 'ACTIVE',User::NOACTIVE => 'NOACTIVE',User::EXPIRE =>'EXPIRE',User::DELETED => 'DELETED']) ?>
