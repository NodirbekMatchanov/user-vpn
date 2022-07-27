
<?php
use \yii\helpers\Url;
if (!empty($cabinet)): ?>
    <style>
        .nav-item._active a:hover {
            color: white;
        }
    </style>
    <div class="nav-wrap _space">
        <div class="container">
            <div class="_desktop">
                <div class="nav">
                    <div class="nav-item <?=Yii::$app->controller->id == 'tariff' ? '_active' : ''?>"><a href="<?=Url::to(['/tariff'])?>">Тарифы</a></div>
                    <div class="nav-item <?=Yii::$app->controller->action->id == 'account' ? '_active' : ''?>"><a href="<?=Url::to(['/user/settings/account'])?>">Аккаунт</a></div>
                    <div class="nav-item <?=Yii::$app->controller->id == 'vpn-ips' ? '_active' : ''?>"><a href="<?=Url::to(['/vpn-ips/list'])?>">Серверы</a></div>
                    <div class="nav-item <?=Yii::$app->controller->action->id == 'config' ? '_active' : ''?>"><a href="<?=Url::to(['/tariff'])?>">Конфигурация</a></div>
                    <div class="nav-item <?=Yii::$app->controller->id == 'support' ? '_active' : ''?>"><a href="<?=Url::to(['/support/categories'])?>">Справочник</a></div>
                </div>
            </div>

            <div class="_mob">
                <div class="dropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-current">Серверы</div>
                        <div class="dropdown-icon">
                            <img src="/web/img/icons/dropdown-2.svg">
                        </div>
                    </div>
                    <div class="dropdown-content">
                        <a href='<?=Url::to(['/tariff'])?>' class="dropdown-item">Тарифы</a>
                        <a href='<?=Url::to(['/user/settings/account'])?>' class="dropdown-item">Аккаунт</a>
                        <a href='<?=Url::to(['/vpn-ips/list'])?>' class="dropdown-item">Серверы</a>
                        <a href='<?=Url::to(['/tariff'])?>' class="dropdown-item">Конфигурация</a>
                        <a href='<?=Url::to(['/support/categories'])?>' class="dropdown-item">Справочник</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="nav-wrap _space">
        <div class="container">
            <div class="_desktop">
                <div class="nav">
                    <div class="nav-item _active">Windows</div>
                    <div class="nav-item">Android</div>
                    <div class="nav-item">iOS</div>
                    <div class="nav-item">macOS</div>
                    <div class="nav-item">Linux</div>
                    <div class="nav-item">Роутер</div>
                </div>
            </div>

            <div class="_mob">
                <div class="dropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-current">Windows</div>
                        <div class="dropdown-icon">
                            <img src="/web/img/icons/dropdown-2.svg">
                        </div>
                    </div>
                    <div class="dropdown-content">
                        <a href='#' class="dropdown-item">Android</a>
                        <a href='#' class="dropdown-item">iOS</a>
                        <a href='#' class="dropdown-item">macOS</a>
                        <a href='#' class="dropdown-item">Linux</a>
                        <a href='#' class="dropdown-item">Роутер</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
