<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\templates\gii\crud\Generator */

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

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel <?= $generator->searchModelClass ?> */

$this->title = '<?= $modelNameShownPl ?>';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="<?= $modelNameId ?>-index">
    <div class="container">

        <h1>
            <?= "<?=" ?> Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= "<?=" ?> Html::a(
                '<span class="glyphicon glyphicon-plus"></span> Create <?= $modelNameShown ?>',
                ["create"],
                ["class" => "btn btn-primary"]
            ); ?>
            </span>
        </h1>

        <div class="">
            <?= "<?=" ?> $this->render("_table", [
                "searchModel" => $searchModel,
                "models"      => $dataProvider->getModels(),
            ]) ?>
        </div>
    </div>
</div>