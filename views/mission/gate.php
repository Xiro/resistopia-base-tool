<?php

use app\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use app\models\Staff;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\assets\page\GateAsset;
use app\models\MissionStatus;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $tables \yii\db\ActiveQuery[] */
/* @var $model \app\models\forms\MissionGateForm */

$this->title = 'Hellgate Control';
$this->params['breadcrumbs'][] = $this->title;

GateAsset::register($this);

?>
<div class="mission-control">
    <div class="container">

        <h1><?= $this->title ?></h1>

        <?php $form = ActiveForm::begin([
            "options"     => ["class" => "animated-label"],
            "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
        ]); ?>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'mission_lead_rpn')->textInput([
                    'class' => 'form-control mask-rpn',
                    'data'  => [
                        'load' => Url::to(['mission/gate'])
                    ]
                ]) ?>
            </div>
        </div>

        <?php if ($model->id): ?>

            <h2>
                <?= "Mission: " . $model->name ?>
                <small class="heading-btn-group pull-right">
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['mission/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['mission/update', 'id' => $model->id],
                        ['target' => '_blank']
                    ) ?>
                </small>
            </h2>

            <b>Status:</b> <?= ucfirst($model->missionStatus->name) ?><br>

            <div class="row">
                <div class="col-xs-6">
                    <h4>In Base</h4>
                </div>
                <div class="col-xs-6">
                    <h4>On Mission</h4>
                </div>
            </div>

            <?= $this->render('../staff/_table-assign', [
            'selectableDataProvider' => new ActiveDataProvider([
                'query' => $model->getStaff()
                    ->joinWith('team')
                    ->where(['status_in_base' => 1]),
            ]),
            'selectedDataProvider'   => new ActiveDataProvider([
                'query' => $model->getStaff()
                    ->joinWith('team')
                    ->where(['status_in_base' => 0]),
            ]),
            'form'                   => $form,
            'exclude'                => ['callsign'],
            'model'                  => new \app\models\forms\MissionGateForm(),
            'searchModel'            => false,
        ]) ?>

            <div class="form-group">
                <?php $statusIds = MissionStatus::getStatusIds() ?>
                <?= Html::submitButton(
                    'Mission Active',
                    [
                        "name"  => "MissionGateForm[mission_status_id]",
                        "value" => $statusIds['active'],
                        "class" => "btn btn-primary"
                    ]
                ) ?>
                <?= Html::submitButton(
                    'Mission Back',
                    [
                        "name"  => "MissionGateForm[mission_status_id]",
                        "value" => $statusIds['back'],
                        "class" => "btn btn-primary"
                    ]
                ) ?>
                <?= Html::submitButton(
                    'Save without status change',
                    ["class" => "btn btn-primary"]
                ) ?>
            </div>

        <?php elseif ($model->mission_lead_rpn): ?>

            <h2>Mission not found</h2>

            <p>
                Possible reasons:
                <ul>
                    <li>The mission status is not ready, active or back</li>
                    <li>The scanned RPN does not belong to the mission leader</li>
                </ul>
            </p>

        <?php endif; ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>