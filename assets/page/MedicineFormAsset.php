<?php

namespace app\assets\page;

use app\assets\AppAsset;
use yii\web\AssetBundle;

class MedicineFormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/medicine-form.css',
    ];
    public $js = [
        'js/medicine-form.js',
    ];
    public $depends = [
        AppAsset::class,
    ];

}