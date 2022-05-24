<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserEvents */

$this->title = 'Create User Events';
$this->params['breadcrumbs'][] = ['label' => 'User Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-events-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
