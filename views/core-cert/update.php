<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CoreCert */

$this->title = 'Update Core Cert: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Core Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="core-cert-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
