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
                    $count = $data->accs->untildate ? (\app\components\DateFormat::countDays($data->accs->untildate) ): 0;
                    return $count;
                }
            ],
//            'op',
//            'value',
            [
                'attribute' => 'username',
                'content' => function ($data) {
                    return $data->username ?? '';
                }
            ],
            [
                'attribute' => 'status',
                'contentOptions' => function ($model, $key, $index, $column) {
                    $class = 'td-default';
                    if ($model->accs->status == 'NOACTIVE') {
                        $class = 'NoActiveStatus';
                    } elseif ($model->accs->status == 'ACTIVE') {
                        $class = 'ActiveStatus';
                    } elseif ($model->accs->status == 'DELETED') {
                        $class = 'DeletedStatus';
                    }

                    return [
                        'key' => $key,
                        'index' => $index,
                        'class' => $class,
                    ];
                },
                'content' => function ($data) {
                    $status = $data->accs->status ?? '';
                    return $status;
                }
            ],

            'last_date_visit',
            'visit_count',
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
