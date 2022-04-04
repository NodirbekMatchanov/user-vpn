<?php

use kartik\sidenav;

// OR if this package is installed separately, you can use
// use kartik\sidenav\SideNav;
use yii\helpers\Url;
$items = [];
$items [] = ['label' => 'Все',  'url' => ['support/categories'], 'active' => false];
foreach ($data as $cayegory => $item) {
    if($cayegory == 'other') continue;
    $items[] = ['label' => $cayegory,  'url' => ['support/categories?category='.$cayegory], 'active' => false];
}
echo sidenav\SideNav::widget([
    'type' => sidenav\SideNav::TYPE_DEFAULT,
    'encodeLabels' => false,
    'heading' => 'Категории',
    'items' => $items
//    'items' => [
//        ['label' => 'Home', 'icon' => 'home', 'url' => ['/site/home'], 'active' => false],
//        ['label' => 'Books', 'icon' => 'book', 'items' => [
//            ['label' => '<span class="pull-right float-right float-end badge">10</span> New Arrivals', 'url' => ['/site/new-arrivals'], 'active' =>  false],
//            ['label' => '<span class="pull-right float-right float-end badge">5</span> Most Popular', 'url' => ['/site/most-popular'], 'active' =>  false],
//        ]],
//    ],
]);