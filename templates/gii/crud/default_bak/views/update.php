<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\templates\gii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$modelNameShown = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$modelNameShownPl = Inflector::pluralize($modelNameShown);
$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = 'Update <?= $modelNameShown ?>';
$this->params['breadcrumbs'][] = ['label' => '<?= $modelNameShownPl ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="<?= $modelNameId ?>-update">

    <h1><?= '<?= Html::encode($this->title) ?>' ?></h1>

    <?= '<?= $this->render("_form", [
        "model" => $model,
    ]) ?>' . "\n" ?>

</div>