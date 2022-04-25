<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DnsServers */

$this->title = 'Create Dns Servers';
$this->params['breadcrumbs'][] = ['label' => 'Dns Servers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dns-servers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
