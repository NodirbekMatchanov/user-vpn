<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История покупок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'content' => function ($data) {
                    if(!empty($data->user_id)) {
                        return  \app\models\Accs::find()->select('email')->where(['user_id' => $data->user_id])->one()->email ?? '';
                    }
                    return "";
                }
            ],
//            'orderId',
            [
                'attribute' => 'tariff',
                'content' => function ($data) {
                    $countDay = 0;
                    switch ($data->tariff) {
                       case "1_month" : $countDay = 30;
                        break;
                       case "6_month" : $countDay = 180;
                        break;
                       case "12_month" : $countDay = 365;
                        break;
                    }
                    return $countDay;
                }
            ],
            [
                'attribute' => 'type',
                'content' => function ($data) {
                    $type = "";
                    switch ($data->type) {
                       case "web" : $type = "На сайте";
                        break;
                       case "app" : $type = "На мобил";
                        break;
                    }
                    return $type;
                }
            ],
            [
                'attribute' => 'promocode',
                'content' => function ($data) {
                    if(!empty($data->user_id) && !$data->promocode) {
                        return \app\models\Accs::find()->select('promocode')->where(['user_id' => $data->user_id])->one()->promocode ?? '';
                    }
                    return $data->promocode;
                }
            ],
            [
                'attribute' => 'regDate',
                'content' => function ($data) {
                    if(!empty($data->user_id)) {
                        $date =  \app\models\Accs::find()->select('datecreate')->where(['user_id' => $data->user_id])->one()->datecreate ?? '' ;
                        return $date ? date("d.m.Y", $date) : "";
                    }
                    return "";
                }
            ],
            [
                'attribute' => 'datecreate',
                'content' => function ($data) {
                    if(!empty($data->user_id)) {
                        $date = \app\models\Accs::find()->select('datecreate')->where(['user_id' => $data->user_id])->one()->datecreate ?? '' ;
                        return $date ? date("d.m.Y", $date) : "";
                    }
                    return "";
                }
            ],
            //'amount',
            'status',
            [
                'attribute' => 'status',
                'content' => function ($data) {
                    return $data->status == 2 ? 'Успешно' : 'Ошибка';
                }
            ],
        ],
    ]); ?>


</div>
