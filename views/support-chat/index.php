<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupportChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Chats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-chat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Support Chat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'chatId',
            'managerId',
            'message:ntext',
            'created',
            //'is_new',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SupportChat $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
