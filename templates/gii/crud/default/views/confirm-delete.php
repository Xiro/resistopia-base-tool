<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\templates\gii\crud\Generator */

$modelNameShown = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$modelNameShownPl = Inflector::pluralize($modelNameShown);
$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = 'Delete <?= $modelNameShown ?>';
$this->params['breadcrumbs'][] = ['label' => '<?= $modelNameShownPl ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $modelNameId ?>-confirm-delete">

    <div class="container-fluid padding-large-vertical">

        <h2><?= '<?= Html::encode($this->title) ?>' ?></h2>

        <div class="text-large">
            <p class="padding-large-vertical">
                Are you sure you want to delete the <?= $modelNameShown ?> <b>'<?= '<?= $model->' . $generator->getNameAttribute() . ' ?>' ?>'</b>?
            </p>
            <div class="row">
                <div class="col-md-6">
                    <?= '<?= Html::a(
                        "Yes",
                        ["delete", "id" => $model->id],
                        [
                            "class" => "btn btn-default btn-block",
                            "data" => ["method" => "post"]
                        ]
                    ) ?>' . "\n" ?>
                </div>
                <div class="col-md-6">
                    <?= '<?= Html::a(
                        "No",
                        ["index"],
                        ["class" => "btn btn-default btn-block"]
                    ) ?>' . "\n" ?>
                </div>
            </div>
        </div>
    </div>

</div>