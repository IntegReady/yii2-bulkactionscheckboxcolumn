<?php

namespace integready\bulkactionscheckboxcolumn;

use yii\base\Widget;
use yii\bootstrap\ButtonDropdown as BBDropdown;
use yii\helpers\ArrayHelper;
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
     * @var string
     */
    public $buttonClass = 'btn';

    /**
     * @var array
     */
    public $buttonOptions = [];

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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * @return bool|string
     * @throws \Exception
     */
    public function run()
    {
        if (!empty($this->items) && is_array($this->items) && count($this->items) >= 1) {
            $items = [];
            foreach ($this->items as $key => $item) {
                $items[] = [
                    'label'       => $item,
                    'url'         => '#',
                    'linkOptions' => [
                        'data-status' => $key,
                        'data-field'  => $this->field,
                        'class'       => $this->selectorName,
                    ],
                ];
            }

            $button = BBDropdown::widget([
                'id'       => 'parent-' . $this->selectorName,
                'label'    => $this->label,
                'dropdown' => [
                    'items' => $items,
                ],
                'options'  => ArrayHelper::merge([
                    'class' => $this->buttonClass,
                ], $this->buttonOptions),
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
        ButtonDropdownAsset::register($view);
        $options = [
            'selectorName' => $this->selectorName,
        ];

        $view->registerJs(
            'if (window.yiiOptionsDropdown === undefined) { yiiOptionsDropdown = []; yiiOptionsDropdown.push(' . Json::htmlEncode($options) . ');} else {yiiOptionsDropdown.push(' . Json::htmlEncode($options) . ');}',
            View::POS_HEAD,
            'yiiOptionsDropdown_' . $this->gridId
        );
    }
}
