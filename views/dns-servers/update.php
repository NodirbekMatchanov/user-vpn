<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DnsServers */

$this->title = 'Dns сервер: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dns Servers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dns-servers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
