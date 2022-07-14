<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="questions-item">
    <div class="questions-item-content">
        <h3 class='questions-item-title'><a href="<?= '/support/categories?category='.Yii::$app->request->get('category').'&id='.$model->id?>"><?= HtmlPurifier::process($model->question) ?></a></h3>
        <div class='questions-item-description'>
            <?= strip_tags(\app\components\CString::truncate(HtmlPurifier::process($model->answer),300)) ?>
        </div>
        <div class="spacer"></div>
        <a href='<?= '/support/categories?category='.Yii::$app->request->get('category').'&id='.$model->id?>' class="questions-item-more">Читать далее</a>
    </div>
</div>
<br>