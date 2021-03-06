<?php

namespace integready\bulkactionscheckboxcolumn;

use Yii;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class BulkCheckboxAction
 */
class BulkCheckboxAction extends Action
{
    const UPDATE_TYPE_ALL      = 1;
    const UPDATE_TYPE_ONEBYONE = 0;

    /**
     * @var ActiveRecord
     */
    public $modelClass;

    /**
     * @var string
     */
    public $gridId;

    /**
     * @var string
     */
    public $statusField;

    /**
     * @var array|null
     */
    public $values;

    /**
     * @var int
     */
    public $updateType = self::UPDATE_TYPE_ALL;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $postUrl = Yii::$app->request->get();
        $data    = empty(Yii::$app->request->get($this->gridId . '_' . $this->statusField)) ? false : Json::decode(Yii::$app->request->get($this->gridId . '_' . $this->statusField), true);
        if ($data && count($data) >= 1) {
            if (is_array($this->values) && isset($this->values[$data['status']])) {
                if ($this->updateType === self::UPDATE_TYPE_ALL) {
                    $this->modelClass::updateAll([$this->statusField => $this->values[$data['status']]], [$this->modelClass::primaryKey()[0] => $data['ids']]);
                } elseif ($this->updateType === self::UPDATE_TYPE_ONEBYONE) {
                    $models = $this->modelClass::find()->where([$this->modelClass::primaryKey()[0] => $data['ids']])->all();
                    foreach ($models as $model) {
                        $model->{$this->statusField} = $this->values[$data['status']];
                        $model->save();
                    }
                }
            } else {
                if ($this->updateType === self::UPDATE_TYPE_ALL) {
                    $this->modelClass::updateAll([$this->statusField => $data['status']], [$this->modelClass::primaryKey()[0] => $data['ids']]);
                } elseif ($this->updateType === self::UPDATE_TYPE_ONEBYONE) {
                    $models = $this->modelClass::find()->where([$this->modelClass::primaryKey()[0] => $data['ids']])->all();
                    foreach ($models as $model) {
                        $model->{$this->statusField} = $data['status'];
                        $model->save();
                    }
                }
            }
        }

        if (!empty($postUrl[$this->gridId . '_' . $this->statusField])) {
            unset($postUrl[$this->gridId . '_' . $this->statusField]);
            $urlParams = ArrayHelper::merge(['index'], $postUrl);
            Yii::$app->response->redirect(Url::to($urlParams));
        }
    }
}
