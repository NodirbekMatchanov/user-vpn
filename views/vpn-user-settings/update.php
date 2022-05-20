<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VpnUserSettings */

$this->title = 'Редактирование : ' . $model->accs->email ?? '';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->accs->email ?? '', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="vpn-user-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
