<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TelegramManagers */

$this->title = 'Update Telegram Managers: ' . $model->chat_id;
$this->params['breadcrumbs'][] = ['label' => 'Telegram Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->chat_id, 'url' => ['view', 'chat_id' => $model->chat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="telegram-managers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
