<?php

namespace integready\bulkactionscheckboxcolumn;

use yii\bootstrap\ButtonDropdown as BBDropdown;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class ButtonDropdown extends Widget
{

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $field;

    /**
     * @var string
     */
    public $selectorName = 'updateStatusIds';

    /**
     * @var string
     */
    public $gridId = 'gridview-index';

    /**
     * Items list
     * ```
     * [
     *      Model::STATUS_ACTIVE    => 'Status active',
     *      Model::STATUS_INACTIVE  => 'Status inactive',
     * ]
     * ```
     * @var array
     */
    public $items;

    /**
     * @var string
     */
    public $float = 'left';

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
        if (!empty($this->items) && is_array($this->items) && count($this->items) >= 1) {
            $items = [];
            foreach ($this->items as $key => $item) {
                $items[] = [
                    'label' => $item,
                    'url' => '#',
                    'linkOptions' => [
                        'data-status' => $key,
                        'data-field' => $this->field,
                        'class' => $this->selectorName,
                    ],
                ];
            }

            $button = BBDropdown::widget([
                'label' => $this->label,
                'dropdown' => [
                    'items' => $items,
                ],
            ]);

            $field = Html::input('hidden', $this->field, '');

            return $button . $field;
        }

        return false;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {

        $view = $this->getView();
        ButtonDropdownAssets::register($view);
        $options = [
            'selectorName' => $this->selectorName,
        ];

        $view->registerJs(
            'if (window.yiiOptions === undefined) { yiiOptions = []; yiiOptions.push(' . Json::htmlEncode($options) . ');} else {yiiOptions.push(' . Json::htmlEncode($options) . ');}',
            View::POS_HEAD,
            'yiiOptions_' . $this->gridId
        );
    }
}
