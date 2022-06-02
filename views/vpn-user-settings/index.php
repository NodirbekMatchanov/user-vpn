<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VpnUserSettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vpn-user-settings-index">

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
            [
                'attribute' => 'email',
                'content' => function ($data) {
                    if(empty($data->accs)){
                        return '';
                    }
                    return  $data->accs ? Html::a($data->accs->email,'view?id='.$data->id) : '';
                }
            ],
            [
                'attribute' => 'tariff',
                'content' => function ($data) {
                    if(empty($data->accs)){
                        return '';
                    }
                    return  $data->accs->tariff ?? $data->accs->tariff;
                }
            ],
            [
                'attribute' => 'expire',
                'content' => function ($data) {
                    if(empty($data->accs)){
                        return '';
                    }
                    return $data->accs->untildate ? (\app\components\DateFormat::countDaysBetweenDates($data->accs->untildate, time()) + 1) : '';
                }
            ],
//            'op',
//            'attribute',
            'value',
            [
                'attribute' => 'username',
                'content' => function ($data) {
                    return $data->username ?? '';
                }
            ],
            [
                'attribute' => 'status',
                'content' => function ($data) {
                    return $data->accs->status ?? '';
                }
            ],
            [
                'attribute' => 'datecreate',
                'content' => function ($data) {
                    if(empty($data->accs)){
                        return '';
                    }
                    return $data->accs->datecreate ? date("d.m.Y", $data->accs->datecreate) : '';
                }
            ],
            [
                'attribute' => 'untildate',
                'content' => function ($data) {
                    if(empty($data->accs)){
                        return '';
                    }
                    return $data->accs->untildate ? date("d.m.Y", $data->accs->untildate) : '';
                }
            ],
            [
                 'header' => 'Действия',
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update} {delete}',

            ],
        ],
    ]); ?>


</div>
