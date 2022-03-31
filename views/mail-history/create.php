<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MailHistory */

$this->title = 'Create Mail History';
$this->params['breadcrumbs'][] = ['label' => 'Mail Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
