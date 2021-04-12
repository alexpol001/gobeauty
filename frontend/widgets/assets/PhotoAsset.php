<?php

namespace frontend\widgets\assets;

use yii\web\AssetBundle;

class PhotoAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets';
    public $css = [
        'css/photo.css',
        'plugins/crop/css/imgareaselect-animated.css'
    ];
    public $js = [
        'plugins/crop/scripts/jquery.imgareaselect.js',
        'js/photo.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
