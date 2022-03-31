<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VpnUserSettings */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
            'pass',
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
                'attribute' => 'datecreate',
                'content' => function ($data) {
                    return $data->accs->datecreate ? date("d.m.Y", $data->accs->datecreate) : '';
                }
            ],
        ],
    ]) ?>

</div>
