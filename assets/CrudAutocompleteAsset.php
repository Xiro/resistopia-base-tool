<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class CrudAutocompleteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/gii/crud-autocomplete.js',
    ];
    public $depends = [
        YiiAsset::class,
    ];

}