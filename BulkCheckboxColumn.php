<?php

namespace integready\bulkactionscheckboxcolumn;

use kartik\grid\CheckboxColumn;

/**
 * Class BulkCheckboxColumn
 */
class BulkCheckboxColumn extends CheckboxColumn
{
    const BUTTON_TYPE_DROPDOWN  = 1;
    const BUTTON_TYPE_CUSTOM_JS = 0;

    /**
     * @var array
     */
    public $elements;

    /**
     * @var string
     */
    protected $fieldFilterSelector = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $grid = $this->grid;

        $buttons = '';
        if (!empty($this->elements) && count($this->elements) >= 1) {
            $comma = false;
            foreach ($this->elements as $key => $element) {
                if (isset($element['visible']) && $element['visible'] === false) {
                    continue;
                }

                if (!isset($element['buttonType']) || $element['buttonType'] === self::BUTTON_TYPE_DROPDOWN) {

                    $element['field'] = $grid->getId() . '_' . $element['field'];
                    if ($comma) {
                        $this->fieldFilterSelector .= ', input[name=\'' . $element['field'] . '\']';
                    } else {
                        $this->fieldFilterSelector .= 'input[name=\'' . $element['field'] . '\']';
                        $comma                     = true;
                    }

                    $buttons .= ButtonDropdown::widget([
                        'label'         => $element['label'],
                        'field'         => $element['field'],
                        'selectorName'  => $grid->id . '-ids',
                        'gridId'        => $grid->id,
                        'buttonClass'   => isset($element['buttonClass']) ? $element['buttonClass'] : null,
                        'buttonOptions' => isset($element['buttonOptions']) ? $element['buttonOptions'] : [],
                        'items'         => $element['items'],
                    ]);
                } elseif ($element['buttonType'] === self::BUTTON_TYPE_CUSTOM_JS) {
                    $buttons .= ButtonSingle::widget([
                        'label'         => $element['label'],
                        'selectorName'  => $grid->id . '-ids',
                        'gridId'        => $grid->id,
                        'buttonClass'   => isset($element['buttonClass']) ? $element['buttonClass'] : null,
                        'buttonOptions' => isset($element['buttonOptions']) ? $element['buttonOptions'] : [],
                        'customJs'      => $element['customJs'],
                    ]);
                } else {
                    continue;
                }
            }
        }

        $grid->toolbar = [
            'content' => $buttons,
            '{export}',
            '{toggleData}',
        ];

        if (!empty($this->fieldFilterSelector)) {
            if (!empty($grid->filterSelector)) {
                $grid->filterSelector .= ', ' . $this->fieldFilterSelector;
            } else {
                $grid->filterSelector = $this->fieldFilterSelector;
            }
        }
    }
}
