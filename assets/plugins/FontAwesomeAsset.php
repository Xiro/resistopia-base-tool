<?php

namespace app\assets\plugins;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $basePath = "@webroot";
    public $baseUrl = "@web";
    public $css = [
        "plugins/font-awesome/font-awesome.css"
    ];
}