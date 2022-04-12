<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsedPromocodes */

$this->title = 'Create Used Promocodes';
$this->params['breadcrumbs'][] = ['label' => 'Used Promocodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="used-promocodes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
