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

<style>
    .servers-table tr th {
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
    .servers-table tr:first-child td {
        color: #0090F8;
        font-weight: 500;
    }
    .servers-table tr th {
        padding: 10px 21px;
    }
    .servers-table tr:first-child td {
        font-weight: 400;
        color: #232323;
    }
    .servers-table thead tr td input {
        height: 40px;
        border-radius: 10px;
        color: inherit;
        padding: 10px 21px;
        background: none;
        border: 1px solid #ABABAB;
        font-size: 14px;
        transition: border 300ms;
        margin: 10px;
    }

</style>
<div class="servers">
    <div class="container">
        <div class="servers-wrap">
            <h3 class="title-3"><?= Html::encode($this->title) ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => '#',
                'contentOptions' => ['style' => 'width:50px', 'class' => ''],
                'headerOptions' => ['style' => 'width:50px',],
                'format' => 'raw',
                'value' => function ($data) {
                    return "<span>".$data->id."</span>";
                }
            ],
            [
                'attribute' => 'ip',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<span>".$data->ip."</span>";
                }
            ],
            [
                'attribute' => 'country',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<span>".$data->country."</span>";
                }
            ],
            [
                'attribute' => 'city',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<span>".$data->city."</span>";
                }
            ],
            [
                'attribute' => 'la',
                'format' => 'raw',
                'value' => function ($data) {
                if(empty($data->serverLoad->la)){
                    return '';
                }
                    return "<span>".$data->serverLoad->la.' %' ?? ''."</span>";
                }
            ],

        ],
        'options' => ['class' => 'datatable  datatable-default datatable-primary datatable-subtable datatable-loaded'],
        'tableOptions' => ['class' => 'servers-table ', 'id' => 'kt_table_1'],
        'rowOptions' => ['class' => 'datatable-row datatable-row-even'],
        'headerRowOptions' => ['class' => 'datatable-row datatable-cell-center'],
    ]); ?>


        </div>
    </div>
</div>
