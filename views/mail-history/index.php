<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MailHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История отправки';
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
            [
                'attribute' => 'email',
                'content' => function ($data) {
                    $accs = \app\models\Accs::find()->where(['email' => $data->email])->one();
                    return  Html::a($data->accs->email,['/vpn-user-settings/view?id='.($accs->vpnid ?? '')]);
                }
            ],
            'subject',
            'body:ntext',
            'datecreate',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \app\models\MailHistory $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
