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
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use <?= $generator->searchModelClass ?>;
<?php if($generator->enableSelect2Fields): ?>
use kartik\select2\Select2;
<?php endif; ?>
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel <?= $searchModelName ?> */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["<?= $modelNameUrl ?>/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => '<?= $modelNameId ?>-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#<?= $modelNameId ?>-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered <?= $modelNameId ?>-table" id="<?= $modelNameId ?>-search-table">
    <thead>
    <?= "<?php" ?> if ($searchModel): ?>
        <?= "<?php" ?> $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?= "<?php" ?> $model = $searchModel ?>
<?php $foreignKeyColumns = $generator->getForeignKeyColumns(); ?>
<?php foreach ($generator->getTableSchema()->columns as $column):
    if($generator->excludeColumnInViewTable($column)) continue;
    $excludeName = in_array($column->name, $foreignKeyColumns) ? $generator->getRelationName($column->name) : $column->name;
?>
            <?= "<?php" ?> if (!in_array("<?= $excludeName ?>", $exclude)): ?>
                <?= "<?php" ?> $excludeSearchParams[] = "<?= $column->name ?>"; ?>
                <th class="<?= $excludeName ?>">
                    <?= "<?= " . $generator->generateActiveField($column->name, 5) . " ?>\n" ?>
                </th>
            <?= "<?php" ?> endif; ?>
<?php endforeach; ?>
            <?= "<?php" ?> if (!in_array("actions", $exclude)): ?>
                <th>
                    <input type="hidden" name="page" value="<?= "<?= " ?> $dataProvider->pagination->page ?>">
                    <input type="hidden" name="per-page" value="<?= "<?= " ?> $dataProvider->pagination->pageSize ?>">
                    <?= "<?php\n" ?>
                    $hiddenAttributes = $searchModel->getAttributes(null, $excludeSearchParams);
                    foreach ($hiddenAttributes as $name => $value) {
                        if($value === null) continue;
                        echo $form->field($searchModel, $name)->hiddenInput(['value' => $value])->label(false);
                    }
                    ?>
                </th>
            <?= "<?php" ?> endif; ?>
        </tr>
    <?= "<?php" ?> else: ?>
        <tr>
<?php foreach ($generator->getTableSchema()->columns as $column):
    if($generator->excludeColumnInViewTable($column)) continue;
    $excludeName = in_array($column->name, $foreignKeyColumns) ? $generator->getRelationName($column->name) : $column->name;
?>
            <?= "<?php" ?> if (!in_array("<?= $excludeName ?>", $exclude)): ?>
                <th class="<?= $excludeName ?>"><?= '<?= ' . $generator->generateString($model->getAttributeLabel($column->name)) . ' ?>'?></th>
            <?= "<?php" ?> endif; ?>
<?php endforeach; ?>
            <?= "<?php" ?> if (!in_array("actions", $exclude)): ?>
                <th></th>
            <?= "<?php" ?> endif; ?>
        </tr>
    <?= "<?php" ?> endif; ?>
    </thead>
    <?= "<?=" ?> $this->render("_table-body", [
        "dataProvider" => $dataProvider,
        "exclude"      => $exclude
    ]); ?>
</table>