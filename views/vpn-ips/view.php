<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VpnIps */

$this->title = $model->host ?? $model->ip;
$this->params['breadcrumbs'][] = ['label' => 'Серверы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->host;
\yii\web\YiiAsset::register($this);
?>
<div class="vpn-ips-view">

    <h1><?= Html::encode($model->host) ?></h1>

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
            'ip',
            'host',
            'provider',
            'status',
            'country',
            'city',
            [
                'attribute' => 'cert',
                'content' => function ($data) {
                    return ($data->cert != '') ? Html::a($data->cert, '/web/certs/' . $data->cert) : null;
                }
            ],
            'ikev2',
            'openvpn',
            [
                'attribute' => 'expire',
                'content' => function ($data) {
                    if (empty($data->expire)) {
                        return '';
                    }
                    return $data->expire ? date("d.m.Y", strtotime($data->expire)) : '';
                }
            ],
            'type',
        ],
    ]) ?>

</div>
