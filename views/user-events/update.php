<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserEvents */

$this->title = 'Update User Events: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-events-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
