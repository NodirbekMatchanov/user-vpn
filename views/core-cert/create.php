<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CoreCert */

$this->title = 'Create Core Cert';
$this->params['breadcrumbs'][] = ['label' => 'Core Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="core-cert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
