<?php
/* @var $data app\models\Support */
/* @var $dataProvider app\models\Support */
$this->title = 'Справочник';
$this->params['breadcrumbs'][] = $this->title;
$category = '';
if($category = Yii::$app->request->get('category')){
    $this->params['breadcrumbs'][] = $category;
}
?>
<style>
    .nav {
        display: inline!important;
        align-items: center;
        justify-content: center;
    }
    body{

    }
    .search {
        position: relative; }

    .search__input {
        width: 100%;
        padding: 20px 32px 21px 59px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        outline: none;
        color: rgb(0, 100, 177);
        font-size: 18px;
        border-radius: 4px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        transition: background .4s, box-shadow .2s; }
    .search__input::-webkit-input-placeholder {
        color: inherit; }
    .search__input:-moz-placeholder {
        color: inherit; }
    .search__input::-moz-placeholder {
        color: inherit; }
    .search__input:-ms-input-placeholder {
        color: inherit; }
    .search__input:hover {
        background: rgba(255, 255, 255, 0.27);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.03); }
    .search__input:active, .search__input:focus {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.14);
        background: white;
        color: #3a3c4c; }
    .search__input:active::-webkit-input-placeholder, .search__input:focus::-webkit-input-placeholder {
        color: #9fa0a8; }
    .search__input:active:-moz-placeholder, .search__input:focus:-moz-placeholder {
        color: #9fa0a8; }
    .search__input:active::-moz-placeholder, .search__input:focus::-moz-placeholder {
        color: #9fa0a8; }
    .search__input:active:-ms-input-placeholder, .search__input:focus:-ms-input-placeholder {
        color: #9fa0a8; }
    .search__input.o__rtl {
        padding: 20px 59px 21px 32px; }

    .search__submit {
        width: 22px;
        height: 22px;
        border: none;
        background: transparent;
        position: absolute;
        top: 50%;
        left: 19px;
        margin-top: -10px;
        outline: none;
        cursor: pointer;
        transition: transform .1s linear; }
    .animation__header-lite .search__submit, .page__header-lite .search__submit, .header__lite .search__submit {
        transform: scale(0.85); }
    .search__submit:before {
        content: ' ';
        border: 2px solid #0062ae;
        border-radius: 50%;
        position: absolute;
        top: 0;
        left: 0;
        width: 16px;
        height: 16px; }
    .search__submit:after {
        content: ' ';
        border-top: 2px solid #0065b2;
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 12px;
        height: 1px;
        transition: width .1s linear;
        transform-origin: 100% 50%;
        transform: rotate(-135deg); }
    .search__submit.o__rtl {
        left: auto;
        right: 19px; }

    .search__headline {
        padding: 16px 0 11px 0;
        margin: -5px 0;
        color: #3a3c4c;
        font-weight: 600;
        letter-spacing: .02em;
        font-size: 18px; }

    .search__clear-text__icon {
        position: absolute;
        right: 0;
        top: 50%;
        width: 32px;
        height: 32px;
        box-sizing: border-box;
        margin-top: -14px; }

    .interface-icon {
        width: 25px;
        height: 25px;
        display: inline-block;
        vertical-align: middle;
        text-align: center; }

    .interface-icon path {
        fill: #0062ae !important;
        fill-opacity: 0.01; }

    .search__input:focus + .search_icons .search__submit, .search__input:active + .search_icons .search__submit {
        pointer-events: none; }
    .search__input:focus + .search_icons .search__submit:before, .search__input:focus + .search_icons .search__submit:after, .search__input:active + .search_icons .search__submit:before, .search__input:active + .search_icons .search__submit:after {
        border-color: #0068b8; }
    .search__input:focus + .search_icons .icon__visible path, .search__input:active + .search_icons .icon__visible path {
        fill-opacity: 1; }

    .search__loading {
        opacity: 0;
        transition: opacity 0.2s ease-out; }

    .search__results {
        opacity: 1;
        animation-name: fadeInOpacity;
        animation-iteration-count: 1;
        animation-timing-function: ease-in;
        animation-duration: 0.2s; }





</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="container" style="margin-top: 50px">
    <form action="/ru/" autocomplete="off" class="header__form search" style="background: whitesmoke">
        <input type="text" autocomplete="off" class="search__input js__search-input o__ltr" placeholder="Поиск ответов..." tabindex="1" name="q" value="">
        <div class="search_icons">
            <button type="submit" class="search__submit o__ltr"></button>
            <a class="search__clear-text__icon">
                <svg class="interface-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M8.018 6.643L5.375 4 4 5.375l2.643 2.643L4 10.643 5.375 12l2.643-2.625L10.625 12 12 10.643 9.357 8.018 12 5.375 10.643 4z"></path>
                </svg>
            </a>

        </div></form>
<br>
    <div class="row">
        <div class="col-sm-3">
            <?= $this->render('_sidebar', [
                'data' => $data,
            ]) ?>
        </div>
        <div class="col-sm-9">
            <?php if(Yii::$app->request->get('id')):?>
                <?= $this->render('_view', [
                    'model' => $model,
                ]) ?>
            <?php else:?>
                <h3><?= ($category) ? $category : 'Все'?></h3>
                <?=
                \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_list',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                    ],
                ]);
                ?>
            <?php endif;?>
        </div>
    </div>

</div>