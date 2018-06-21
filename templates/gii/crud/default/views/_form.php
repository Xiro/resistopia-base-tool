<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mate\yii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

$modelNameId = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
<?php if($generator->generateFormModel): ?>
/* @var $model <?= ltrim($generator->formModelClass, '\\') ?> */
<?php else: ?>
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
<?php endif; ?>
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="<?= $modelNameId ?>-form">

    <?= '<?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>' . "\n\n" ?>
<?php
$beginRow = true;
$t = "    ";
foreach ($generator->getColumnNames() as $attribute) {
    if (!in_array($attribute, $safeAttributes)) {
        continue;
    }

    if($beginRow) {
        echo "$t<div class=\"row\">\n";
    }

    echo "$t$t<div class=\"col-md-6\">\n";
    echo "$t$t$t<?= " . $generator->generateActiveField($attribute, 3) . " ?>\n";
    echo "$t$t</div>\n";

    if(!$beginRow) {
        echo "$t</div>\n\n";
    }
    $beginRow = !$beginRow;
}
if(!$beginRow) {
    echo "$t</div>\n\n";
}
?>
    <div class="form-group">
        <?= '<?= Html::submitButton(
            $model->isNewRecord ? ' . $generator->generateString('Create') . ' : ' . $generator->generateString('Update') . ',
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>' . "\n" ?>
    </div>

    <?= "<?php" ?> ActiveForm::end(); ?>

</div>