<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

$modelNameShown = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$modelNameShownPl = Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)));
$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));
$modelClassName = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
<?php if($generator->generateFormModel): ?>
/* @var $model <?= ltrim($generator->formModelClass, '\\') ?> */
<?php else: ?>
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
<?php endif; ?>

$this->title = <?= $generator->generateString('Approve {subject}', [
    'subject' => $generator->generateString($modelNameShown)
]) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($modelNameShownPl) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $modelNameId ?>-approve">

    <?= "<?=" ?> $this->render("_detail", [
        "model" => $model,
    ]) ?>

    <?= "<?php" ?> $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label ajax-form"],
        'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="form-group">
        <?= "<?=" ?> $form->field($model, 'id')->hiddenInput()->label(false); ?>
        <?= "<?=" ?> $form->field($model, 'approved')->hiddenInput(["id" => "value-approved"])->label(false); ?>
        <?= "<?=" ?> Html::submitButton('<span class="glyphicon glyphicon-ok"></span> ' . <?= $generator->generateString('Approve') ?>, [
                'name'  => '<?= $modelClassName ?>[approved]',
                'value' => 1,
                'class' => 'btn btn-success approval-btn',
            ]
        ) ?>
        <?= "<?=" ?> Html::submitButton('<span class="glyphicon glyphicon-remove"></span> ' . <?= $generator->generateString('Decline') ?>, [
                'name'  => '<?= $modelClassName ?>[approved]',
                'value' => 0,
                'class' => 'btn btn-danger approval-btn',
            ]
        ) ?>
    </div>
    <?= "<?php" ?> ActiveForm::end(); ?>

</div>