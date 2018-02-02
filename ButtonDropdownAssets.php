<?php

namespace integready\bulkactionscheckboxcolumn;

use yii\web\AssetBundle;

/**
 * Class ButtonDropdownAssets
 */
class ButtonDropdownAssets extends AssetBundle
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
        'js/script.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
