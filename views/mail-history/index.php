<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MailHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mail Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-history-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',
            'body:ntext',
            'datecreate',
            'email:email',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \app\models\MailHistory $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
