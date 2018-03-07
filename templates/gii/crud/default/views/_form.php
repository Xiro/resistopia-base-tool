<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\templates\gii\crud\Generator */

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

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
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
    echo "$t$t$t<?= " . $generator->generateActiveField($attribute) . " ?>\n";
    echo "$t$t</div>\n";

    if(!$beginRow) {
        echo "$t</div>\n\n";
    }
    $beginRow = !$beginRow;
} ?>
    <div class="form-group">
        <?= '<?= Html::submitButton(
            $model->isNewRecord ? "Create" : "Update",
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>' . "\n" ?>
    </div>

    <?= "<?php" ?> ActiveForm::end(); ?>

</div>