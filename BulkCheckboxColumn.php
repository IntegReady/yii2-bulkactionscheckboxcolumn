<?php

namespace integready\bulkactionscheckboxcolumn;

use kartik\grid\CheckboxColumn;

/**
 * Class BulkCheckboxColumn
 */
class BulkCheckboxColumn extends CheckboxColumn
{
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
                $element['field'] = $grid->getId() . '_' . $element['field'];
                if ($comma) {
                    $this->fieldFilterSelector .= ', input[name=\'' . $element['field'] . '\']';
                } else {
                    $this->fieldFilterSelector .= 'input[name=\'' . $element['field'] . '\']';
                    $comma = true;
                }

                $buttons .= ButtonDropdown::widget([
                    'label' => $element['label'],
                    'field' => $element['field'],
                    'selectorName' => $grid->id . '-ids',
                    'gridId' => $grid->id,
                    'items' => $element['items'],
                ]);
            }
        }

        $grid->toolbar = [
            'content' => $buttons,
            '{export}',
            '{toggleData}'
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
