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
<div class="servers">
    <div class="container">
        <div class="servers-wrap">
            <h3 class="title-3"><?= Html::encode($this->title) ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ip',
            'country',
            'city',
            [
                'attribute' => 'la',
                'content' => function ($data) {
                if(empty($data->serverLoad->la)){
                    return '';
                }
                    return $data->serverLoad->la.' %' ?? '';
                }
            ],

        ],
    ]); ?>


        </div>
    </div>
</div>
