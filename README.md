Bulk actions checkbox column
============================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist integready/yii2-bulkactionscheckboxcolumn "@dev"
```

or add

```
"integready/yii2-bulkactionscheckboxcolumn": "@dev"
```

to the require section of your `composer.json` file.

Inserting a widget in GridView:
--

### Included variables (`#INCLUDED`):
###### # These are NOT variables, you do not need to write them into the code, replace them with the correct strings or your variables! They are for what would be clear where you need to write the same para- meters.
* `$idGrid // string`
* `$fieldFirst // string`
* `$itemsFirst // array(1 => 'On', 0 => 'Off')`
* `$nameActionFirst // string`
* `$fieldNext // string`
* `$itemsNext // array(1 => 'On', 0 => 'Off')`
* `$nameActionNext // string`
* `$perPageName // string`

### Example:
* index.php `(View)`:
```php
<?php

use kartik\grid\GridView;

?>
<?= GridView::widget([
    'id' => $idGrid, #INCLUDED
    'dataProvider'   => $dataProvider,
    'filterModel'    => $searchModel,
    'columns'        => [
        [
            'class' => 'integready\bulkactionscheckboxcolumn\BulkCheckboxColumn',
            'elements' => [
                [
                    'label' => 'Text first button',
                    'field' => $fieldFirst, #INCLUDED
                    'items' => $itemsFirst, #INCLUDED
                ],
                // ...Many elements
                [
                    'label' => 'Text next button',
                    'field' => $fieldNext, #INCLUDED
                    'items' => $itemsNext, #INCLUDED
                ]
            ],
        ],
        // Other columns
    ],
]); ?>
```

* SiteController.php `(Controller)`:
```php
<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Site;
use yii\helpers\ArrayHelper;
use backend\models\SiteSearch;
use integready\bulkactionscheckboxcolumn\BulkStatusAction;

/**
 * SiteController implements the CRUD actions for Site model.
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            $nameActionFirst => [ #INCLUDED
                'class' => BulkStatusAction::className(),
                'modelClass' => Site::className(),
                'gridId' => $idGrid, #INCLUDED
                'statusField' => $fieldFirst, #INCLUDED
            ],
            // ...Many actions
            $nameActionNext => [ #INCLUDED
                'class' => BulkStatusAction::className(),
                'modelClass' => Site::className(),
                'gridId' => $idGrid, #INCLUDED
                'statusField' => $fieldNext, #INCLUDED
            ],
        ]);
    }
    
    /**
     * Index page
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->runAction($nameActionFirst); #INCLUDED
        // ...Many actions with run
        $this->runAction($nameActionNext); #INCLUDED

        $searchModel  = new SiteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    // Other actions and methods
}
```
