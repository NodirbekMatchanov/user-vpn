<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VpnIps */

$this->title = 'Добавить Ип сервер';
$this->params['breadcrumbs'][] = ['label' => 'Cерверы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vpn-ips-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
