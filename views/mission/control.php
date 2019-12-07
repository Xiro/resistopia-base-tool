<?php

use app\helpers\Html;
use app\models\MissionStatus;
use mate\yii\widgets\SelectData;
use yii\data\ActiveDataProvider;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $tables \yii\db\ActiveQuery[] */
/* @var $title string */

$this->title = $title ? $title : 'Mission Control';
$this->params['breadcrumbs'][] = $this->title;

$typeIds = SelectData::fromModel(\app\models\MissionType::class, "name", "id");

?>
<?php if (!Yii::$app->request->isAjax): ?>
<style type="text/css">
    .page-heading {
        margin-bottom: -16px!important;
    }
    .status-heading {
        margin-bottom: -16px!important;
        margin-top: 40px!important;
    }
    .mission-control-status-row {
        font-size: 1.4em;
        border: 1px solid #000!important;
        padding: 0!important;
    }
    .mission-control-operation-row {
        border-bottom-width: 2px;
        border-left: 1px solid #000!important;
        border-right: 1px solid #000!important;
        padding-top: 24px!important;
        padding-left: 0!important;
    }
</style>
<div class="mission-control">
    <div class="container">

        <h1 class="page-heading">
            <?= $this->title ?>

            <span class="heading-btn-group">
                    <?= Glyphicon::refresh(['class' => 'btn-auto-reload active']) ?>
            </span>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create Mission',
                ["create"],
                ["class" => "btn btn-default"]
            ); ?>
            </span>
        </h1>
        <?php endif; ?>

        <div class="reload-target">
            <table class="table table-bordered">
                <?php foreach ($tables as $label => $query): ?>
                <?php if ($query->count() == 0) continue; ?>
                <tr>
                    <td colspan="5" class="mission-control-status-row">
                        <h3 class="status-heading"><?= $label ?></h3>
                    </td>
                </tr>
                    <?php
                    $query->orderBy("operation_id ASC");
                    $operation = false;
                    /** @var \app\models\Mission $model */ ?>
                    <?php foreach($query->all() as $model): ?>
                        <?php if($operation !== $model->operation_id): ?>
                            <tr>
                                <td colspan="5" class="mission-control-operation-row">
                                    <b><?= $model->operation_id ? $model->operation->name : "Keine Operation" ?></b>
                                </td>
                                <?php $operation = $model->operation_id ?>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td style="width: 31px; text-align: center">
                                <?php
                                switch ($model->mission_type_id) {
                                    case $typeIds['Patrouille']:
                                        echo Glyphicon::road(['title' => 'Patrouille']);
                                        break;
                                    case $typeIds['Aufklärung']:
                                        echo Glyphicon::search(['title' => 'Aufklärung']);
                                        break;
                                    case $typeIds['Auftrag']:
                                        echo Glyphicon::envelope(['title' => 'Auftrag']);
                                        break;
                                    case $typeIds['Rettung']:
                                        echo Glyphicon::plus(['title' => 'Rettung']);
                                        break;
                                    case $typeIds['Kampf']:
                                        echo Glyphicon::screenshot(['title' => 'Kampf']);
                                        break;
                                }
                                ?>
                            </td>
                            <td><?= $model->name ?></td>
                            <td><?= $model->troop_name ?></td>
                            <td style="width: 70px; text-align: center"><?= implode(', ', $model->callsigns); ?></td>
                            <td class="action-status-buttons">
                                <?php
                                $statusData = SelectData::fromModel(MissionStatus::class, 'name', 'id');
                                $status = $model->mission_status_id ? $model->missionStatus->name : null;
                                switch ($model->missionStatus->name) {
                                    case null:

                                    case 'planing':
                                        echo Html::a(
                                            Html::button(
                                                Glyphicon::transfer() . ' Active',
                                                ['class' => 'btn btn-default']
                                            ),
                                            [
                                                'mission/switch-status',
                                                'missionId' => $model->id,
                                                'statusId'  => $statusData['active'],
                                            ]
                                        );
                                        break;
                                    case 'active':
                                        echo Html::a(
                                            Html::button(
                                                Glyphicon::transfer() . ' Back',
                                                ['class' => 'btn btn-default']
                                            ),
                                            [
                                                'mission/switch-status',
                                                'missionId' => $model->id,
                                                'statusId'  => $statusData['back'],
                                            ]
                                        );
                                        break;
                                    case 'back':
                                        echo Html::a(
                                            Html::button(
                                                Glyphicon::edit() . ' Debrief',
                                                ['class' => 'btn btn-default']
                                            ),
                                            ['mission/debrief', 'id' => $model->id]
                                        );
                                        break;
                                }
                                ?>
                            </td>
                            <td class="actions">
                                <?= Html::a(
                                    Glyphicon::eye_open(),
                                    ['mission/view', 'id' => $model->id],
                                    ["class" => "ajax-dialog", "data-size" => "lg"]
                                ) ?>
                                <?= Html::a(
                                    Glyphicon::pencil(),
                                    ['mission/update', 'id' => $model->id]
                                ) ?>
                                <?= Html::a(
                                    Glyphicon::trash(),
                                    ['mission/confirm-delete', 'id' => $model->id],
                                    ["class" => "ajax-dialog", "data-size" => "sm"]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
        </div>
        <?php if (!Yii::$app->request->isAjax): ?>

    </div>
</div>

<?php endif; ?>