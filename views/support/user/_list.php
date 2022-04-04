<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="news-item">
    <hr>
    <a href="<?= '/web/support/categories?category='.Yii::$app->request->get('category').'&id='.$model->id?>"> <h4 class="question"><?= HtmlPurifier::process($model->question) ?></h4></a>
    <?= \app\components\CString::truncate(HtmlPurifier::process($model->answer),300) ?>
</div>