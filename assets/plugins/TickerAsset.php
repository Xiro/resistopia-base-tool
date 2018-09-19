<?php

namespace app\assets\plugins;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class TickerAsset extends AssetBundle
{
    public $basePath = "@webroot";
    public $baseUrl = "@web";
    public $js = [
        "plugins/ticker/ticker.js"
    ];
    public $css = [
        "plugins/ticker/ticker.css"
    ];
    public $depends = [
        YiiAsset::class
    ];
}