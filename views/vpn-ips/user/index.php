<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VpnIpsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cерверы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vpn-ips-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ip',
            'status',
            'country',
            'city',
            'host',
            'login',
            'load_serv',
            'password',
            'expire',
            [
                'attribute' => 'cert',
                'content' => function ($data) {
                    return ($data->cert != '') ? Html::a($data->cert,  '/web/certs/'.$data->cert) : null;
                }
            ],
            'status',

        ],
    ]); ?>


</div>
