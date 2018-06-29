<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $accessKey app\models\forms\AccessKeyForm */
/* @var $model app\models\Staff */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = "Grant Rights to " . $model->nameWithRpn;
?>

<div class="staff-grant-rights-form">

    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <?= $this->render('../access-right/_checkboxes', [
        'form'      => $form,
        'model'     => $accessKey,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            'Update rights',
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
