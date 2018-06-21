<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
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

$this->title = <?= $generator->generateString('Update {subject}', [
    'subject' => $generator->generateString($modelNameShown),
]); ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($modelNameShownPl) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
?>
<div class="<?= $modelNameId ?>-update">
    <div class="container">
        <h1><?= '<?= Html::encode($this->title) ?>' ?></h1>

        <?= '<?= $this->render("_form", [
            "model" => $model,
        ]) ?>' . "\n" ?>
    </div>
</div>