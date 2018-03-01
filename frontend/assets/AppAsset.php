<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/index.css',
        'css/lightbox.min.css',
        'https://fonts.googleapis.com/css?family=Oswald'
    ];
    public $js = [
        'js/index.js',
        'js/question.js',
        'js/lightbox.min.js',
        'js/yii.confirm.overrides.js',
        'https://use.fontawesome.com/2998a92670.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\SweetAlertAsset',
    ];
}
