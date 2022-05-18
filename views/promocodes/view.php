<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Promocodes */

$this->title = $model->promocode;
$this->params['breadcrumbs'][] = ['label' => 'Промокоды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="promocodes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обнавить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'promocode',
            'expire',
            'user_limit',
            'status',
            'description:ntext',
            'discount',
            'free_day',
            'comment:ntext',
            'author',
            'country',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <h3>Пользователи</h3>
    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th>Email</th>
            <td>дата и время</td>
            <td>тип подписки</td>
        </tr>
    <?php  foreach ($usedUsers as $user): ?>
        <?php if(!empty($usersData[$user['user_id']])):?>
        <tr>
            <th><?=$usersData[$user['user_id']]['email']?></th>
            <td><?=$user['date']?></td>
            <td><?=$usersData[$user['user_id']]['tariff']?></td>
        </tr>
        <?php endif; ?>
    <?php endforeach;?>
        </tbody>
    </table>

</div>
