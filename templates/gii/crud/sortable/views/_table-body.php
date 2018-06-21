<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$modelClassName = StringHelper::basename($generator->modelClass);
$modelNameShown = Inflector::camel2words($modelClassName);
$modelNameShownPl = Inflector::pluralize(Inflector::camel2words($modelClassName));
$modelNameId = Inflector::camel2id($modelClassName);
$modelNameUrl = $modelNameId;

$searchModelName = StringHelper::basename($generator->searchModelClass);

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass();

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
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $exclude array */

use yii\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
$pagination->totalCount = $dataProvider->totalCount;
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= "<?=" ?> $pagination->page + 1 ?>"
       data-page-size="<?= "<?=" ?> $pagination->pageSize ?>"
       data-page-count="<?= "<?=" ?> $pagination->pageCount ?>">
<?= "<?php" ?> /** @var $model \<?= $generator->modelClass ?> */ ?>
<?= "<?php" ?> foreach ($dataProvider->getModels() as $model): ?>
    <tr class="ui-sortable-handle" data-key="<?= "<?=" ?> $model-><?= $generator->getTableSchema()->primaryKey[0] ?> ?>">
        <?= "<?php" ?> if (!in_array("order", $exclude)): ?>
            <td class="order order-content">
                <?= "<?= \$model->order; ?>\n" ?>
            </td>
        <?= "<?php" ?> endif; ?>
<?php foreach ($generator->getTableSchema()->columns as $column):
    if($generator->excludeColumnInViewTable($column) || $column->name == 'order') continue;
    $foreignKeyColumns = $generator->getForeignKeyColumns();
    if (in_array($column->name, $foreignKeyColumns)) {

        $relatedSchema = $generator->getRelationSchema($column->name);
        $relationName = $generator->getRelationName($column->name);

        if($relatedSchema && method_exists($relatedSchema['class'], '__toString')) {
            $callVarString = '$model->' . $relationName;
        } elseif($relatedSchema && $nameAttribute = $generator->getNameAttribute($relatedSchema["class"])) {
            $callVarString = '$model->' . $relationName . ' ? $model->' . $relationName . '->' . $nameAttribute . ' : "None"';
        } else {
            $callVarString = '"n/a" // IMPLEMENT FOR: $model->' . $relationName;
        }

        $excludeName = $relationName;
    } else {
        $excludeName = $column->name;
        $callVarString = '$model->' . $column->name;
    }
?>
        <?= "<?php" ?> if (!in_array("<?= $excludeName ?>", $exclude)): ?>
            <td class="<?= $excludeName . ($column->name == "order" ? " order-content" : "")?>">
                <?= "<?= " . $callVarString . " ?>\n" ?>
            </td>
        <?= "<?php" ?> endif; ?>
<?php endforeach; ?>
        <?= "<?php" ?> if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?= "<?php" ?> if (!in_array("action-view", $exclude)): ?>
                    <?= "<?=" ?> Html::a(
                        Glyphicon::eye_open(),
                        ['<?= $modelNameUrl ?>/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?= "<?php" ?> endif; ?>
                <?= "<?php" ?> if (!in_array("action-update", $exclude)): ?>
                    <?= "<?=" ?> Html::a(
                        Glyphicon::pencil(),
                        ['<?= $modelNameUrl ?>/update', 'id' => $model->id]
                    ) ?>
                <?= "<?php" ?> endif; ?>
                <?= "<?php" ?> if (!in_array("action-delete", $exclude)): ?>
                    <?= "<?=" ?> Html::a(
                        Glyphicon::trash(),
                        ['<?= $modelNameUrl ?>/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?= "<?php" ?> endif; ?>
            </td>
        <?= "<?php" ?> endif; ?>
    </tr>
<?= "<?php" ?> endforeach; ?>
</tbody>