<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$modelNameShown = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$modelNameShownPl = Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)));
$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));
$modelClassName = StringHelper::basename($generator->modelClass);

$searchModelName = StringHelper::basename($generator->searchModelClass);

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use mate\yii\assets\ApprovalAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString('Approve {subjects}', [
    'subjects' => $generator->generateString($modelNameShownPl)
]) ?>;;
$this->params['breadcrumbs'][] = $this->title;

ApprovalAsset::register($this);
?>
<div class="<?= $modelNameId ?>-approval-index">
    <div class="container">

        <h1><?= "<?=" ?> Html::encode($this->title) ?></h1>

        <div class="cropped-width-md padding-large-vertical">
            <div class="hidden" id="return-url" data-url="<?= "<?=" ?> Url::to(["index"]) ?>"></div>
            <div class="text-large text-center">
                <?= "<?=" ?> Html::tag("a", "Previous", [
                    'class' => 'btn btn-default approve-previous'
                ]) ?>
                <?= "<?=" ?> <?= $generator->generateString('Approve {count} {subjects}', [
                        'count' => '\'<span class="approve-count">\' . $dataProvider->count . \'</span>\'',
                    'subjects' => $generator->generateString(strtolower($modelNameShownPl))
                ]) ?> ?>
                <?= "<?=" ?> Html::tag("a", "Next", [
                    'class' => 'btn btn-default approve-next'
                ]) ?>
            </div>

            <div class="row">
                <div id="approval-views" class="col-sm-12 padding-large-vertical">
                    <?= "<?php" ?> foreach ($dataProvider->models as $pos => $model): ?>
                        <div data-view-url="<?= "<?=" ?> Url::to(["approve", "id" => $model->id]) ?>"
                             data-pos="<?= "<?=" ?> $pos ?>"
                             class="approval-view">
                        </div>
                    <?= "<?php" ?> endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>