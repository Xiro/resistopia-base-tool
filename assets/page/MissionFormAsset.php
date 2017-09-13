<?php

namespace app\assets\page;

use yii\web\AssetBundle;

class MissionFormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/mission-form.css',
    ];
    public $js = [
        'js/mission-form.js',
    ];
    public $depends = [
        IndexSearchAsset::class,
    ];

}