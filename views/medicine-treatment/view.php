<?php

use app\helpers\Html;
use app\assets\page\MedicineFormAsset;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\MedicineTreatment */

$this->title = "Behandlung " . $model->patient->name;
$this->params['breadcrumbs'][] = ['label' => 'Medicine Treatments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

MedicineFormAsset::register($this);
?>
<div class="medicine-treatment-view container-fluid">

    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a(
            Glyphicon::eye_open(),
            ['staff/view', 'id' => $model->patient_sid],
            [
                'style' => 'font-size:22px',
                'class' => 'ajax-dialog',
            ]
        ) ?>
        <span class="pull-right">
        <?= Html::a(
            "Bearbeiten",
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary',]
        ) ?>
        <?= Html::a(
            "Löschen",
            ['confirm-delete', 'id' => $model->id],
            [
                'class'     => 'btn btn-danger ajax-dialog',
                "data-size" => "sm"
            ]
        ) ?>
        </span>
    </h1>

    <div class="row">
        <div class="col-sm-4 text-center">
            <div class="injury-select-img" style="cursor: default">
                <?= Html::img(Yii::getAlias('@web/img/human-silhouette_600.png'), [
                    'class' => '',
                ]); ?>
                <?php foreach ($model->injuries as $key => $injury): ?>
                    <div class="injury-mark" style="top:<?= $injury->y ?>%;left:<?= $injury->x ?>%">
                        <span class="glyphicon glyphicon-screenshot"></span>
                        <span class="badge"><?= $key + 1 ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-8">

            <h4>Verletzungen</h4>

            <p>
                <?php foreach ($model->injuries as $key => $injury): ?>
                    <?= $key + 1 ?>. <?= $injury->injury . ($injury->annotation ? ", " . $injury->annotation : '') ?>
                    <br>
                <?php endforeach; ?>
            </p>

            <?php if ($model->impairment): ?>
                <h4>Dauerhafte Beeinträchtigungen</h4>
                <p><?= nl2br($model->impairment) ?></p>
            <?php endif; ?>

            <?php if ($model->aftercare): ?>
                <h4>Notwendige Nachbehandlung</h4>
                <p><?= nl2br($model->aftercare) ?></p>
            <?php endif; ?>

            <b>Einsatztauglichkeit:</b> <?= ucfirst($model->operational_fitness) ?>

            <h4>Vitalwerte</h4>

            <?php
            $vitals = [];
            $vitals["Atmung"] = $model->breathing;
            $vitals["Atmung (Details)"] = $model->breathing_details ? $model->breathing_details : 'Keine';
            $vitals["Pupillen"] = $model->pupils;
            $vitals["Puls"] = $model->pulse ? $model->pulse : 'Nicht gemessen';
            $vitals["Temperatur"] = $model->temperature ? $model->temperature : 'Nicht gemessen';
            $vitals["Blutdruck"] = $model->blood_pressure_systolic . '/' . $model->blood_pressure_diastolic;
            ?>
            <div class="model-details row vitals-info">
                <?php foreach ($vitals as $label => $value): ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-12 detail-label" style="text-align: left;padding-top: 8px">
                                <?= $label ?>
                            </div>
                            <div class="col-sm-12 detail-value">
                                <?= $value ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <h4>Behandlung</h4>

            <?php
            $treatment = [];
            $treatment["Vorbehandlung"] = $model->pretreatment;
            $treatment["Medi Foam"] = $model->medi_foam;
            ?>
            <div class="model-details row treatment-info">
                <?php foreach ($treatment as $label => $value): ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-12 detail-label" style="text-align: left;padding-top: 8px">
                                <?= $label ?>
                            </div>
                            <div class="col-sm-12 detail-value">
                                <?= $value ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($model->getMedications()->count()): ?>
                <h4>Medikation</h4>

                <p>
                    <?php foreach ($model->medications as $medication): ?>
                        - <?= $medication->drug->name . ", " . lcfirst($medication->location) ?>
                        <br>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>

        </div>
    </div>

</div>
