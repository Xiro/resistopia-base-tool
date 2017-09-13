<?php

namespace app\assets\plugins;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class DialogAsset extends AssetBundle
{
    public $basePath = "@webroot";
    public $baseUrl = "@web";
    public $js = [
        "plugins/dialog/dialog.js"
    ];
    public $css = [
        "plugins/dialog/dialog.css"
    ];
    public $depends = [
        YiiAsset::class
    ];
}