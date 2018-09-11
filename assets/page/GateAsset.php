<?php

namespace app\assets\page;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class GateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/index-search.css',
    ];
    public $js = [
        'js/gate.js',
    ];
    public $depends = [
        YiiAsset::class,
    ];

}