<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\page\MedicineFormAsset;

/* @var $this yii\web\View */
/* @var $model app\models\MedicineCheckup */

$this->title = "A38 " . $model->patient->nameWithRpn;
$this->params['breadcrumbs'][] = ['label' => 'Medicine Checkups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

MedicineFormAsset::register($this);
?>
<div class="medicine-checkup-view container-fluid">


    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a(
            'Update',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Delete',
            ['confirm-delete', 'id' => $model->id],
            ['class' => 'btn btn-danger ajax-dialog', "data-size" => "sm"]
        ) ?>
        </span>
    </h1>


    <div class="row">
        <div class="col-sm-4 text-center">
            <div class="injury-select-img">
                <?= Html::img(Yii::getAlias('@web/img/human-silhouette_600.png'), [
                    'class' => '',
                ]); ?>
                <?php foreach ($model->injuries as $key => $injury): ?>
                    <div class="injury-mark" style="top:<?= $injury->y ?>%;left:<?= $injury->x ?>%">
                        <span class="glyphicon glyphicon-screenshot"></span>
                        <span class="badge"><?= $key+1 ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-8">

            <h4>Verletzungen</h4>

            <ol>
                <?php foreach ($model->injuries as $injury): ?>
                <li>
                    <?= $injury->injury . ($injury->annotation ? ", " . $injury->annotation : '') ?>
                </li>
                <?php endforeach; ?>
            </ol>

            <?php if($model->impairment): ?>
                <h4>Dauerhafte Beeinträchtigungen</h4>
                <p><?= nl2br($model->impairment) ?></p>
            <?php endif; ?>

            <?php if($model->aftercare): ?>
                <h4>Notwendige Nachbehandlung</h4>
                <p><?= nl2br($model->aftercare) ?></p>
            <?php endif; ?>

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

            <h4>Weitere Informationen</h4>

            <?php
            $other = [];
            $other["Ernährungszustand"] = $model->nutrition;
            $other["Psychich Auffällig"] = $model->psyche;
            $other["Hautbild"] = $model->complexion ? $model->complexion : 'Nicht gemessen';
            $other["Impfungen"] = $model->vaccinations ? $model->vaccinations : 'Keine bekannt';
            $other["Vorerkrankungen/Infektionen/Allergien"] = $model->conditions ? $model->conditions : 'Keine bekannt';
            $other["Medikamenten-/Drogenkonsum"] = $model->drug_use ? $model->drug_use : 'Keine bekannt';
            $other["Sonstige Anmerkungen"] = $model->other ? $model->other : 'Keine';
            ?>
            <div class="model-details row other-info">
                <?php foreach ($other as $label => $value): ?>
                    <div class="col-md-12">
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

        </div>
    </div>

</div>
