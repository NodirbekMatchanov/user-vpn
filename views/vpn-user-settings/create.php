<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VpnUserSettings */

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Vpn User Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vpn-user-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
