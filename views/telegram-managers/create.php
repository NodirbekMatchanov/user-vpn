<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TelegramManagers */

$this->title = 'Create Telegram Managers';
$this->params['breadcrumbs'][] = ['label' => 'Telegram Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-managers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
