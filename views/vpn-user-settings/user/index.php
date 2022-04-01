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



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'username',
                'content' => function ($data) {
                    return  Html::a($data->username,'view?id='.$data->id);
                }
            ],
//            'op',
//            'attribute',
            'value',
            [
                'attribute' => 'email',
                'content' => function ($data) {
                    return $data->accs->email ?? '';
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

        ],
    ]); ?>


</div>
