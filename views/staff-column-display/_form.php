<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $model app\models\StaffColumnDisplay */
/* @var $form yii\bootstrap\ActiveForm */
?>

<style type="text/css">
    .staff-column-display-form .form-group {
        margin-bottom: 0;
    }
</style>

<div class="staff-column-display-form">

    <?php $form = ActiveForm::begin([
        "action"      => ['staff/column-display'],
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <h4>Personal Information</h4>

    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'sid')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'name')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'gender')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'date_of_birth')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'height')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'eye_color')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'profession')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'blood_type')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
    </div>

    <h4>Affiliation</h4>

    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'team')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'special_function')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'section')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'department')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'citizenship')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'rank')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
    </div>

    <h4>System</h4>

    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'security_level')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'registered')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'resistance_cell')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'callsign')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'status_alive')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'created')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $form->field($model, 'updated')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            'Adjust Staff Columns',
            ["class" => "btn btn-primary", "style" => "margin-top: 15px; margin-bottom: 30px"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>