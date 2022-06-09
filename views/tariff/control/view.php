<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tariff */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tariff-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    $status = (\app\models\Tariff::ACTIVE == $data->status) ? 'активен' : 'архивный' ;
                    return $status;
                }
            ],
            'price',
            'price_30',
            'day_30',
            'price_180',
            'day_180',
            'price_365',
            'day_365',
            'period',
            'country',
            'currency',
            [
                'attribute' => 'expire',
                'content' => function ($data) {
                    if (empty($data->expire)) {
                        return '';
                    }
                    return $data->expire ? date("d.m.Y", strtotime($data->expire)) : '';
                }
            ],
        ],
    ]) ?>

</div>
