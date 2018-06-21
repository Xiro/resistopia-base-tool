<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\templates\gii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$modelClassName = StringHelper::basename($generator->modelClass);
$modelNameShown = Inflector::camel2words($modelClassName);
$modelNameShownPl = Inflector::pluralize(Inflector::camel2words($modelClassName));
$modelNameId = Inflector::camel2id($modelClassName);
$modelNameUrl = Inflector::slug($modelClassName);

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
use <?= $generator->modelClass ?>;
use <?= $generator->searchModelClass ?>;
<?php if($generator->enableSelect2Fields): ?>
use kartik\select2\Select2;
<?php endif; ?>
use app\helpers\ValMap;
use app\assets\page\IndexSearchAsset;

/* @var $this yii\web\View */
/* @var $models <?= $modelClassName ?>[] */
/* @var $searchModel <?= $searchModelName ?> */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["<?= $modelNameUrl ?>/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    IndexSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'index-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label",
            "data"             => []
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered team-table" id="index-search-table">
    <thead>
    <?= "<?php" ?> if ($searchModel): ?>
        <tr class="animated-label">
            <?= "<?php" ?> $model = $searchModel ?>
<?php $foreignKeyColumns = $generator->getForeignKeyColumns(); ?>
<?php foreach ($generator->getTableSchema()->columns as $column):

    if(
        in_array($column->name, $generator->getTableSchema()->primaryKey)
        || preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)
    ) continue;

    $excludeName = in_array($column->name, $foreignKeyColumns) ? $generator->getRelationName($column->name) : $column->name;
?>
            <?= "<?php" ?> if (!in_array("<?= $excludeName ?>", $exclude)): ?>
                <th class="<?= $excludeName ?>">
                    <?= "<?= " . $generator->generateActiveField($column->name, 5) . " ?>\n" ?>
                </th>
            <?= "<?php" ?> endif; ?>
<?php endforeach; ?>
            <?= "<?php" ?> if (!in_array("actions", $exclude)): ?>
                <th></th>
            <?= "<?php" ?> endif; ?>
        </tr>
    <?= "<?php" ?> else: ?>
        <tr>
<?php foreach ($generator->getTableSchema()->columns as $column):

    if(
        in_array($column->name, $generator->getTableSchema()->primaryKey)
        || preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)
    ) continue;

    $excludeName = in_array($column->name, $foreignKeyColumns) ? $generator->getRelationName($column->name) : $column->name;
?>
            <?= "<?php" ?> if (!in_array("<?= $excludeName ?>", $exclude)): ?>
                <th class="<?= $excludeName ?>"><?= $model->getAttributeLabel($column->name) ?></th>
            <?= "<?php" ?> endif; ?>
<?php endforeach; ?>
            <?= "<?php" ?> if (!in_array("actions", $exclude)): ?>
                <th></th>
            <?= "<?php" ?> endif; ?>
        </tr>
    <?= "<?php" ?> endif; ?>
    </thead>
    <tbody>
    <?= "<?=" ?> $this->render("_table-body", [
        "models"  => $models,
        "exclude" => $exclude
    ]); ?>
    </tbody>
</table>