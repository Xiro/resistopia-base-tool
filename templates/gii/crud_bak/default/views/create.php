<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\templates\gii\crud\Generator */

$modelNameShown = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$modelNameShownPl = Inflector::pluralize($modelNameShown);
$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));
$modelFullyQualified = ltrim($generator->modelClass, '\\');

echo "<?php\n";
?>

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model <?= $modelFullyQualified ?> */

$this->title = 'Create <?= $modelNameShown ?>';
$this->params['breadcrumbs'][] = ['label' => '<?= $modelNameShownPl ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">

    <h1><?= '<?= Html::encode($this->title) ?>' ?></h1>

    <?= '<?= $this->render("_form", [
        "model" => $model,
    ]) ?>' . "\n" ?>

</div>