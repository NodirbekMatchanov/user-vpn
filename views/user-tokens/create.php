<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\api\v1\models\UserTokens */

$this->title = 'Create User Tokens';
$this->params['breadcrumbs'][] = ['label' => 'User Tokens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-tokens-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
