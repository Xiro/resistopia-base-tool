<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use app\assets\plugins\AnimatedLabelFormAsset;
use app\assets\plugins\FontAwesomeAsset;
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
    ];
    public $depends = [
        YiiAsset::class,
        FontAwesomeAsset::class,
        AnimatedLabelFormAsset::class
    ];
}
