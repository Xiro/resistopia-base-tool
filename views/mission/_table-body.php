<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $exclude array */

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;
use mate\yii\widgets\SelectData;
use app\models\MissionStatus;

$pagination = $dataProvider->pagination;
if ($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}
$exclude = !isset($exclude) ? ['time_ete', 'mission_type', 'action-status-buttons'] : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : 0 ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : 0 ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : 0 ?>">
<?php /** @var $model \app\models\Mission */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $model->name ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("operation", $exclude)): ?>
            <td class="operation">
                <?= $model->operation_id ? $model->operation->name : '' ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("mission_type", $exclude)): ?>
            <td class="mission_type">
                <?= $model->mission_type_id ? $model->missionType->name : '' ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("zone", $exclude)): ?>
            <td class="zone">
                <?= $model->zone ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("mission_status", $exclude)): ?>
            <td class="mission_status">
                <?= $model->mission_status_id ? $model->missionStatus->name : '' ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("time_lst", $exclude)): ?>
            <td class="time_lst">
                <?= $model->time_lst ? date('d.m.Y H:i', strtotime($model->time_lst)) : ''; ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("time_ete", $exclude)): ?>
            <td class="time_ete">
                <?= $model->time_ete ? date('d.m.Y H:i', strtotime($model->time_ete)) : ''; ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("time_atf", $exclude)): ?>
            <td class="time_atf">
                <?= $model->time_atf ? date('H:i', strtotime($model->time_atf)) : ''; ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("callsign", $exclude)): ?>
            <td class="callsign">
                <?= implode(', ', $model->callsigns); ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("action-status-buttons", $exclude)): ?>
        <td class="action-status-buttons">
            <?php
            $statusData = SelectData::fromModel(MissionStatus::class, 'name', 'id');
            $status = $model->mission_status_id ? $model->missionStatus->name : null;
            switch ($model->missionStatus->name) {
                case null:
                case 'planing':
                    echo Html::a(
                        Html::button(
                            Glyphicon::transfer() . ' Leadercall',
                            ['class' => 'btn btn-default']
                        ),
                        [
                            'mission/switch-status',
                            'missionId' => $model->id,
                            'statusId'  => $statusData['openLeadercall'],
                        ]
                    );
                    break;
                case 'openLeadercall':
                    echo Html::a(
                        Html::button(
                            Glyphicon::transfer() . ' Crewcall',
                            ['class' => 'btn btn-default']
                        ),
                        [
                            'mission/switch-status',
                            'missionId' => $model->id,
                            'statusId'  => $statusData['openCrewcall'],
                        ]
                    );
                    break;
                case 'openCrewcall':
                    echo Html::a(
                        Html::button(
                            Glyphicon::transfer() . ' Ready',
                            ['class' => 'btn btn-default']
                        ),
                        [
                            'mission/switch-status',
                            'missionId' => $model->id,
                            'statusId'  => $statusData['ready'],
                        ]
                    );
                    break;
                case 'ready':
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
            <?php endif; ?>
        </td>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['mission/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['mission/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['mission/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>