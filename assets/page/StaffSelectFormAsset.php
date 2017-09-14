<?php

namespace app\assets\page;

use yii\web\AssetBundle;

class StaffSelectFormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/staff-select-form.css',
    ];
    public $js = [
        'js/staff-select-form.js',
    ];
    public $depends = [
        IndexSearchAsset::class,
    ];

}