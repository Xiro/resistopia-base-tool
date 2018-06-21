<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>

<?= "<?=" ?> DetailView::widget([
    'model'      => $model,
    "options"    => [
        "class" => "table table-bordered",
    ],
    'attributes' => [
        <?php
foreach ($generator->getTableSchema()->columns as $column) {
    $format = $generator->generateColumnFormat($column);
    if (in_array($column->name, $generator->getTableSchema()->primaryKey) || in_array($column->name, ["order", "approved"])) {
        continue;
    }
    $relation = $generator->getRelationSchema($column->name);
    if ($relation !== false) {
        $label = $generator->getAttributeLabel($column->name);
        $relationAttribute = lcfirst(Inflector::camelize(str_replace("_id", "", $column->name)));
        echo '[
            "attribute"      => "' . $relationAttribute . '.' . $generator->getNameAttribute($relation["class"]) . '",
            "label"          => "' . $label . '",
            "captionOptions" => ["class" => "width-content-adjusted"],
        ],' . "\n" . '        ';
    } else {
        echo '[
            "attribute"      => "' . $column->name . '",
            "captionOptions" => ["class" => "width-content-adjusted"],'
            . ($format === 'text' ? "" : '"format" => "' . $format . '"') . '
        ],' . "\n" . '        ';
    }
}
echo '[
            "attribute"      => "approved",
            "captionOptions" => ["class" => "width-content-adjusted"],
        ],' . "\n" . '        ';
?>

    ],
]) ?>