<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VpnUserSettings */
/* @var $dataProviderEvents app\models\UserEvents */

$this->title = $model->accs->email ?? '';
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$promocodes = [];
if(!empty($model->accs->user_id)) {
    $promocodes = \app\models\UsedPromocodes::find()->where(['user_id' => $model->accs->user_id])->all();
}

?>
<div class="vpn-user-settings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
//            'pass',
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
                'attribute' => 'untildate',
                'content' => function ($data) {
                    return $data->accs->untildate ? date("d.m.Y", $data->accs->untildate) : '';
                }
            ],

            [
                'attribute' => 'tariff',
                'content' => function ($data) {
                    return $data->accs->tariff ?? '';
                }
            ],
            [
                'attribute' => 'role',
                'content' => function ($data) {
                    return $data->accs->role ?? '';
                }
            ],

            [
                'attribute' => 'comment',
                'content' => function ($data) {
                    return $data->accs->comment ?? '';
                }
            ],
            [
                'attribute' => 'test_user',
                'content' => function ($data) {
                    return $data->accs->test_user ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'background_work',
                'content' => function ($data) {
                    return $data->accs->background_work ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'promocode',
                'content' => function ($data) {
                    return $data->accs->promocode ?? '';
                }
            ],

            [
                'attribute' => 'fcm_token',
                'content' => function ($data) {
                    return $data->accs->fcm_token ?? '';
                }
            ],
            [
                'attribute' => 'ios_token',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->ios_token ?? '';
                }
            ],
            [
                'attribute' => 'phone',
                'content' => function ($data) {
                    return $data->accsp->profile->phone ?? '-';
                }
            ],
        ],
    ]) ?>
    <h3>UTM Метки</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'source',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->source ?? 'web';
                }
            ],
            [
                'attribute' => 'utm_source',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->utm_source ?? '';
                }
            ],
            [
                'attribute' => 'utm_medium',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->utm_medium ?? '';
                }
            ],
            [
                'attribute' => 'utm_campaign',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->utm_campaign ?? '';
                }
            ],

            [
                'attribute' => 'utm_term',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->utm_term ?? '';
                }
            ],

        ],
    ]) ?>
    <h3>Cтатистика</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'datecreate',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->datecreate ? date("d.m.Y H:i:s", $data->accs->datecreate) : '';
                }
            ],
            [
                'attribute' => 'last_date_visit',
                'format' => 'raw',
                'value' => function ($data) {
                    if (empty($data->accs)) {
                        return '';
                    }
                    $usage = \app\models\VpnUserSettings::getUseageVpn($data->username);
                    return $usage['last_usage_date'];
                }
            ],
            [
                'attribute' => 'visit_count',
                'format' => 'raw',
                'value' => function ($data) {
                    if (empty($data->accs)) {
                        return '';
                    }
                    $usage = \app\models\VpnUserSettings::getUseageVpn($data->username);
                    return $usage['count'];
                }
            ],
            [
                'attribute' => 'use_ios',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->use_ios ?? '';
                }
            ],
            [
                'attribute' => 'use_android',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->accs->use_android ?? '';
                }
            ],


        ],
    ]) ?>
    <h3>Промокоды</h3>
    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th>Промокод</th>
            <td>Дата</td>
            <td>Тип</td>
        </tr>
    <?php if (!empty($promocodes)): ?>
        <?php foreach ($promocodes as $promocode): ?>
            <tr>
                <th><?=$promocode->promocode?></th>
                <td><?=$promocode->date?></td>
                <td><?=$promocode->type?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
        </tbody>
    </table>
    <h3>События</h3>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderEvents,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'datetime',
            [
                'attribute' => 'event',
                'content' => function ($data) {
                    return \app\models\UserEvents::$eventsRu[$data->event] ?? '';
                }
            ],
            'text:ntext',
        ],
    ]); ?>
</div>
