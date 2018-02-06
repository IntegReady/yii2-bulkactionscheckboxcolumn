<?php

namespace integready\bulkactionscheckboxcolumn;

use yii\web\AssetBundle;

/**
 * Class ButtonSingleAsset
 */
class ButtonSingleAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@integready/bulkactionscheckboxcolumn/assets';

    /**
     * @var array
     */
    public $css = [];

    /**
     * @var array
     */
    public $js = [
        'js/buttonSingle.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
