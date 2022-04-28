<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Translations */

$this->title = 'Добавить перевод';
$this->params['breadcrumbs'][] = ['label' => 'Переводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
