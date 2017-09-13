<?php

namespace app\assets\page;

use app\assets\AppAsset;
use yii\web\AssetBundle;

class StaffSearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/staff-search.css',
    ];
    public $js = [
        'js/staff-search.js',
    ];
    public $depends = [
        AppAsset::class,
    ];

}