<?php

namespace integready\bulkactionscheckboxcolumn;

use Yii;
use yii\helpers\Url;
use yii\base\Action;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Class BulkCheckboxAction
 */
class BulkCheckboxAction extends Action
{
    /**
     * @var \yii\db\ActiveRecord
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
     * @inheritdoc
     */
    public function run()
    {
        $postUrl = Yii::$app->request->get();
        $data    = empty(Yii::$app->request->get($this->gridId . '_' . $this->statusField)) ? false : Json::decode(Yii::$app->request->get($this->gridId . '_' . $this->statusField), true);
        if ($data && count($data) >= 1) {
            $this->modelClass::updateAll([$this->statusField => $data['status']], [$this->modelClass::primaryKey()[0] => $data['ids']]);
        }

        if (!empty($postUrl[$this->gridId . '_' . $this->statusField])) {
            unset($postUrl[$this->gridId . '_' . $this->statusField]);
            $urlParams = ArrayHelper::merge(['did/index'], $postUrl);
            Yii::$app->response->redirect(Url::to($urlParams));
        }
    }
}
