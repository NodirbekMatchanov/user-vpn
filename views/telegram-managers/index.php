<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TelegramManagersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Telegram Managers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-managers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Telegram Managers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'chat_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TelegramManagers $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'chat_id' => $model->chat_id]);
                 }
            ],
        ],
    ]); ?>


</div>
