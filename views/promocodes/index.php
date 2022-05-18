<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PromocodesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Промокоды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocodes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'promocode',

            [
                'attribute' => 'visit',
                'content' => function ($data) {
                    $usedPromo = \app\models\UsedPromocodes::find()->where(['promocode' => $data->promocode, 'type' => \app\models\UsedPromocodes::VISIT])->count();
                    return $usedPromo;
                }
            ],
            [
                'attribute' => 'signup',
                'content' => function ($data) {
                    $usedPromo = \app\models\UsedPromocodes::find()->where(['promocode' => $data->promocode, 'type' => \app\models\UsedPromocodes::SIGNUP])->count();
                    return $usedPromo;
                }
            ],
            [
                'attribute' => 'payout',
                'content' => function ($data) {
                    $usedPromo = \app\models\UsedPromocodes::find()->where(['promocode' => $data->promocode, 'type' => \app\models\UsedPromocodes::PAYOUT])->count();
                    return $usedPromo;
                }
            ],
            [
                'attribute' => 'konverstion',
                'content' => function ($data) {
                    $usedPromoVisit = \app\models\UsedPromocodes::find()->where(['promocode' => $data->promocode, 'type' => \app\models\UsedPromocodes::PAYOUT])->count();
                    $usedPromoPayout = \app\models\UsedPromocodes::find()->where(['promocode' => $data->promocode, 'type' => \app\models\UsedPromocodes::PAYOUT])->count();
                    return $usedPromoVisit > 0 ? (($usedPromoPayout * 100) / $usedPromoVisit) : 0;
                }
            ],
            'status',
            'expire',
            'user_limit',
            //'description:ntext',
            'discount',
            //'free_day',
            //'comment:ntext',
            'country',
            'author',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \app\models\Promocodes $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
