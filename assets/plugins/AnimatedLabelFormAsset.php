<?php

namespace app\assets\plugins;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AnimatedLabelFormAsset extends AssetBundle
{
    public $basePath = "@webroot";
    public $baseUrl = "@web";
    public $js = [
        "plugins/animated-label-form/animated-label-form.js"
    ];
    public $css = [
        "plugins/animated-label-form/animated-label-form.css"
    ];
    public $depends = [
        YiiAsset::class
    ];
}