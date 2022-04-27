<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $model
 */

$this->title = Yii::t('user', 'Тариф');
$this->params['breadcrumbs'][] = $this->title;
$code = Yii::$app->user->identity->promoCodes;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
               <div class="alert alert-info"> <?= (!empty($accs)) ? $accs->tariff.' подписка до '. date("d.m.Y", $accs->untildate) : 'free'?></div>
            </div>
            <div class="container" style="margin: 25px 15px">
                <label>Промокод</label>
                <input name="promocode" placeholder="code" value="<?=$code['promocode'] ?? ''?>" class="input-sm" style="width: 400px" type="text" >
                <button id="usePromocode" class="btn btn-primary <?=(!empty($code) ? 'hidden' : '' )?>"> Применить</button>
                <button id="cancelPromocode" class="btn btn-danger <?=(empty($code) ? 'hidden' : '' )?>"> Отменить</button>
            </div>
        </div>

    </div>
</div>
