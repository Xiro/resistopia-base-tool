<?php

namespace app\assets\page;

use yii\web\AssetBundle;

class StaffAssignFormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/staff-select-form.css',
    ];
    public $js = [
        'js/staff-assign-form.js',
    ];
    public $depends = [
        IndexSearchAsset::class,
    ];

}