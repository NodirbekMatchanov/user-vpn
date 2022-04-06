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
    },6000)
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
            'ip',
            [
                'attribute' => 'status',
                'content' => function ($data) {
                    return Html::dropDownList('serv_status',$data->status,['ACTIVE' => 'активен', 'NOACTIVE' => 'отключен'],['data-id' => $data->id]);
                }
            ],
            'country',
            'city',
            'host',
            'login',
            [
                'attribute' => 'la',
                'content' => function ($data) {
                    return $data->serverLoad->la.' %' ?? '';
                }
            ],
            [
                'attribute' => 'desc',
                'content' => function ($data) {
                    return $data->serverLoad->descr ?? '';
                }
            ],
            'password',
            'expire',
            [
                'attribute' => 'cert',
                'content' => function ($data) {
                    return ($data->cert != '') ? Html::a($data->cert,  '/web/certs/'.$data->cert) : null;
                }
            ],
            [
                'header' => 'Действия',
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update} {delete}',

            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
