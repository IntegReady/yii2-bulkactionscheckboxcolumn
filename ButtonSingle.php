<?php

namespace integready\bulkactionscheckboxcolumn;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class ButtonSingle extends Widget
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $selectorName = 'updateStatusIds';

    /**
     * @var string
     */
    public $gridId = 'gridview-index';

    /**
     * @var string
     */
    public $buttonClass = 'btn';

    /**
     * @var string
     */
    public $customJs;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * @return bool|string
     */
    public function run()
    {
        return Html::button($this->label, [
            'id' => 'single-' . $this->selectorName,
            'class' => $this->buttonClass,
            'data-selector' => $this->selectorName,
        ]);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        ButtonSingleAsset::register($view);
        $options = [
            'selectorName'  => $this->selectorName,
        ];

        $view->registerJs("$(document).on('buttonSingle:click', " . $this->customJs . ");", View::POS_LOAD);

        $view->registerJs(
            'window.yiiOptionsSingle = ' . Json::htmlEncode($options),
            View::POS_HEAD,
            'yiiOptionsSingle_' . $this->gridId
        );
    }
}
