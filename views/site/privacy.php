<?php
/** @var yii\web\View $this */

$this->title = 'Политика конфиденциальности';
$this->params['breadcrumbs'][] = $this->title;
$domain = (\app\models\VpnIps::getSettings()['domain'] ?? 'vpn-max.com');

?>

<div class="container " style="margin-top: 50px">
    <div class="site-privacy">
        <?=\Yii::t('app', 'web-privacy');?>
    </div>

</div>