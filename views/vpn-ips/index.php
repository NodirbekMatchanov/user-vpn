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
$url = Url::to(['/vpn-ips/status']);
$script = <<<JS
$(document).on('change', '[name="serv_status"]', function (e) {
    $.ajax({
        url: '$url',
        method: "POST",
        data: {
            id: $(this).data('id'),
            status: $(this).val()
        }
    }).done(function(){
        alert('status changed')
    });
})

    setInterval(function(){
         $.pjax.reload({container:"#my_pjax"});
    },10000)
JS;
$this->registerJs($script, $this::POS_END);
?>
<div class="vpn-ips-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить сервер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php \yii\widgets\Pjax::begin(['id' => 'my_pjax']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'ip',
                'content' => function ($data) {
                    return  Html::a($data->ip,'view?id='.$data->id);
                }
            ],
            'host',
            [
                'attribute' => 'la',
                'content' => function ($data) {
                    return ($data->serverLoad->la ?? '0') .' %';
                }
            ],
            'ikev2',
            'openvpn',
            'country',
            'city',
            'provider',
            [
                'attribute' => 'expire',
                'content' => function ($data) {
                    if(empty($data->expire)){
                        return '';
                    }
                    return $data->expire ? date("d.m.Y", strtotime($data->expire)) : '';
                }
            ],
            [
                'attribute' => 'status',
                'content' => function ($data) {
                    return Html::dropDownList('serv_status',$data->status,['ACTIVE' => 'активен', 'NOACTIVE' => 'отключен'],['data-id' => $data->id]);
                }
            ],
            'type',
            [
                'attribute' => 'connection',
                'content' => function ($data) {
                    if($data->connection) {
                        $html = "<div class='alert alert-success'>сервер доступен <p>".($data->last_ping_time ? date("d.m.Y H:i",strtotime($data->last_ping_time)) : '')."</p></div>";
                    } else {
                        $html = "<div class='alert alert-danger'>сервер недоступен <p>".($data->last_ping_time ? date("d.m.Y H:i",strtotime($data->last_ping_time)) : '')."</p></div>";
                    }
                    return $html;
                }
            ],
//            [
//                'attribute' => 'desc',
//                'content' => function ($data) {
//                    return $data->serverLoad->descr ?? '';
//                }
//            ],
//            'password',
//            [
//                'attribute' => 'cert',
//                'content' => function ($data) {
//                    return ($data->cert != '') ? Html::a($data->cert,  '/web/certs/'.$data->cert) : null;
//                }
//            ],
            [
                'header' => 'Действия',
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update} {delete}',

            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
