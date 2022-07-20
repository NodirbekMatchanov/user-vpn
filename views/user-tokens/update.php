<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\api\v1\models\UserTokens */

$this->title = 'Update User Tokens: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Tokens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-tokens-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
