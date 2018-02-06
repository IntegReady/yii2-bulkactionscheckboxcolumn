<?php

namespace integready\bulkactionscheckboxcolumn;

use yii\web\AssetBundle;

/**
 * Class ButtonDropdownAsset
 */
class ButtonDropdownAsset extends AssetBundle
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
        'js/buttonDropdown.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
