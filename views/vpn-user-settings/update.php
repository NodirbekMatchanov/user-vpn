<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VpnUserSettings */

$this->title = 'Update Vpn User Settings: ' . $model->accs->email ?? '';
$this->params['breadcrumbs'][] = ['label' => 'Vpn User Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->accs->email ?? '', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vpn-user-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
