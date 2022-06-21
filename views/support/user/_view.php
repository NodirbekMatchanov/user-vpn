<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$category = '';
$this->params['breadcrumbs'][] = $model->question;

?>
<div class="news-item content-support">
    <h3 > <?= HtmlPurifier::process($model->question) ?></h3>
    <?= HtmlPurifier::process($model->answer) ?>
</div>