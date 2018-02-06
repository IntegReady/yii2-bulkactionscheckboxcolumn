Bulk actions checkbox column
============================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist integready/yii2-bulkactionscheckboxcolumn "~1.0"
```

or add

```
"integready/yii2-bulkactionscheckboxcolumn": "~1.0"
```

to the require section of your `composer.json` file.

Usage example:
--
###### GridView id must be set.

* index.php `(View)`:
```php
<?php

use integready\bulkactionscheckboxcolumn\BulkCheckboxColumn;
use kartik\grid\GridView;

?>
<?= GridView::widget([
    'id'            => 'books-grid',
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'columns'       => [
        [
            'class'     => BulkCheckboxColumn::className(),
            'elements'  => [
                [
                    'label'         => 'Change Availability',
                    'field'         => 'available',
                    'items'         => [
                        1 => 'Yes',
                        0 => 'No',
                    ],
                    'visible'       => false,
                ],
                [
                    'label'         => 'Change International Shipping',
                    'field'         => 'intl_shipping',
                    'items'         => [
                        1 => 'Yes',
                        0 => 'No',
                    ],
                ],
                [
                    'label'         => 'Change Author',
                    'field'         => 'author_book',
                    'buttonType'    => BulkCheckboxColumn::BUTTON_TYPE_CUSTOM_JS,
                    'customJs'      => 'function(event, gridId, ids) { /* ... */ }'
                ]
                // ...Many elements
            ],
        ],
        // Other columns
    ],
]); ?>
```

* BookController.php `(Controller)`:
```php
<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Book;
use yii\helpers\ArrayHelper;
use backend\models\BookSearch;

/**
 * BookController implements the CRUD actions for Site model.
 */
class BookController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'bulk_available'        => [
                'class'                 => BulkCheckboxAction::className(),
                'modelClass'            => Book::className(),
                'gridId'                => 'books-grid',
                'statusField'           => 'available',
                'updateType'            => BulkCheckboxAction::UPDATE_TYPE_ONEBYONE,
            ],
            // ...Many actions
            'bulk_intl_shipping'    => [
                'class'                 => BulkCheckboxAction::className(),
                'modelClass'            => Book::className(),
                'gridId'                => 'books-grid',
                'statusField'           => 'intl_shipping',
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
        $this->runAction('bulk_available');
        // ...Many actions with run
        $this->runAction('bulk_intl_shipping');

        $searchModel  = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    // Other actions and methods
}
```
