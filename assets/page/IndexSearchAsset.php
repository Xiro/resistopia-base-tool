<?php

namespace app\assets\page;

use app\assets\AppAsset;
use app\assets\plugins\DialogAsset;
use yii\web\AssetBundle;

class IndexSearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/index-search.css',
    ];
    public $js = [
        'js/index-search.js',
    ];
    public $depends = [
        DialogAsset::class,
        AppAsset::class,
    ];

}