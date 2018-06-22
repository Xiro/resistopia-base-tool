<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use app\assets\plugins\AnimatedLabelFormAsset;
use app\assets\plugins\DialogAsset;
use app\assets\plugins\FontAwesomeAsset;
use mate\yii\assets\JQueryMaskAsset;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/layout.css',
    ];
    public $js = [
        'js/layout.js'
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        FontAwesomeAsset::class,
        AnimatedLabelFormAsset::class,
        DialogAsset::class,
        JQueryMaskAsset::class,
    ];
}
