<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

$modelNameShown = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$modelNameShownPl = Inflector::pluralize($modelNameShown);
$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\Html;


/* @var $this yii\web\View */
<?php if($generator->generateFormModel): ?>
/* @var $model <?= ltrim($generator->formModelClass, '\\') ?> */
<?php else: ?>
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
<?php endif; ?>

$this->title = <?= $generator->generateString('Create {subject}', [
    'subject' => $generator->generateString($modelNameShown),
]); ?>;
$this->params['breadcrumbs'][] = ['label' => '<?= $modelNameShownPl ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <div class="container">
        <h1><?= '<?= Html::encode($this->title) ?>' ?></h1>

        <?= '<?= $this->render("_form", [
        "model" => $model,
    ]) ?>' . "\n" ?>
    </div>
</div>