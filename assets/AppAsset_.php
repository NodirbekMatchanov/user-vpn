<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset_ extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'web/tmp/public/css/styles.css',
        'https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css',
    ];
    public $js = [
        'web/tmp/public/js/base.js',
        'web/tmp/public/js/ready.js',
        'js/main.js',
        'https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
