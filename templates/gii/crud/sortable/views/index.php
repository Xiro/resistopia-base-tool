<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \app\templates\gii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$modelNameShown = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$modelNameShownPl = Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)));
$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));
$modelClassName = StringHelper::basename($generator->modelClass);

$searchModelName = StringHelper::basename($generator->searchModelClass);

$columnCount = count($generator->getColumnNames());
if($columnCount <= 3) {
    $containerClass = "cropped-width-sm";
} elseif($columnCount <= 5) {
    $containerClass = "cropped-width-md";
} elseif($columnCount <= 5) {
    $containerClass = "cropped-width-lg";
} else {
    $containerClass = "";
}
echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\plugins\SortableUpdateAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel yii\data\ActiveDataProvider */

$this->title = '<?= $modelNameShownPl ?>';
$this->params['breadcrumbs'][] = $this->title;

SortableUpdateAsset::register($this);
?>
<div class="<?= $modelNameId ?>-index">
    <div class="container">

        <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

        <div class="<?= $containerClass ?>">

            <?= '<?= \yii\grid\GridView::widget([
                "dataProvider" => $dataProvider,
                "filterModel"  => $searchModel,
                "layout"       => "{items}{pager}",
                "tableOptions" => [
                    "class"                => "table table-bordered sortable",
                    "data-sortable-update" => Url::to(["update-order"]),
                ],
                "columns"      => [' . "\n   " ?>
                <?php foreach ($generator->getTableSchema()->columns as $column) {
                    if(in_array($column->name, $generator->getTableSchema()->primaryKey)) {
                        continue;
                    }
                    $relation = $generator->getRelationSchema($column->name);
                    if($relation !== false) {
                        echo '[
                        "class"          => \'app\components\grid\ModelColumn\',
                        "attribute"      => "' . lcfirst($relation["className"]) . '",
                    ],' . "\n" . '                    ' ;
                    } elseif(!empty($column->enumValues) && in_array($column->enumValues, $generator->booleanEnums)) {
                        echo '[
                        "class"          => \'app\components\grid\BooleanColumn\',
                        "headerOptions"  => ["class" => "width-content-adjusted"],
                        "contentOptions" => ["class" => "width-content-adjusted text-center"],
                        "attribute"      => "' . $column->name . '",
                    ],' . "\n" . '                    ';
                    } elseif($column->name == "order") {
                        echo '[
                        "headerOptions"  => ["class" => "width-content-adjusted"],
                        "contentOptions" => ["class" => "width-content-adjusted text-right order-content"],
                        "attribute"      => "order",
                    ],' . "\n" . '                    ';
                    } elseif ($column->type == "integer") {
                        echo '[
                        "headerOptions"  => ["class" => "width-content-adjusted"],
                        "contentOptions" => ["class" => "width-content-adjusted text-right"],
                        "attribute"      => "' . $column->name . '",
                    ],' . "\n" . '                    ';
                    } else {
                        echo '[
                        "attribute"      => "' . $column->name . '",
                    ],' . "\n" . '                    ' ;
                    }
                }
                echo '[
                        "class"          => "yii\grid\ActionColumn",
                        "contentOptions" => ["class" => "action-column text-right"],
                        "buttonOptions"  => ["class" => "ajax-dialog"],
                        "template"       => "{update} {confirm-delete}",
                        "buttons" => [
                            "confirm-delete" => function ($url) {
                                return Html::a(\'<span class="glyphicon glyphicon-trash"></span>\', $url, ["class" => "ajax-dialog"]);
                            }
                        ]
                    ],' . "\n"?>
                <?= '],

            ]) ?>' . "\n"  ?>

            <?= '<?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Create ' . $modelNameShown . '",
                ["create"],
                ["class" => "btn btn-success ajax-dialog"]
            ); ?>' . "\n" ?>

        </div>
    </div>
</div>