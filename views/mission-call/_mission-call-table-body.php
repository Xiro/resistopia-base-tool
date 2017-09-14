<?php

/* @var $missionCallModels \app\models\MissionCall[] */

use yii\helpers\Html;
use app\widgets\Glyphicon;
?>

<?php foreach ($missionCallModels as $missionCall): ?>
    <tr>
        <td><?= $missionCall->name ?></td>
        <td><?= $missionCall->missionType ? $missionCall->missionType->name : "None" ?></td>
        <td><?= $missionCall->description ?></td>
        <td><?= $missionCall->RP ?></td>
        <td><?= $missionCall->FP ?></td>
        <td><?= $missionCall->zone ?></td>
        <td style="white-space: nowrap">
            <?= $missionCall->scheduled_start ? date("H:i d.m.", strtotime($missionCall->scheduled_start)) : "" ?>
        </td>
        <td style="white-space: nowrap">
            <?= $missionCall->scheduled_end ? date("H:i d.m.", strtotime($missionCall->scheduled_end)) : "" ?>
        </td>
        <td><?= $missionCall->fighter ?></td>
        <td><?= $missionCall->radio ?></td>
        <td><?= $missionCall->medic ?></td>
        <td><?= $missionCall->technician ?></td>
        <td><?= $missionCall->science ?></td>
        <td><?= $missionCall->guard ?></td>
        <td><?= $missionCall->vip ?></td>
        <td>
            <?= Html::a(
                Glyphicon::play(),
                ['mission/create-from-call', 'id' => $missionCall->id],
                ["class" => ""]
            ) ?>
            <?= Html::a(
                Glyphicon::pencil(),
                ['mission-call/update', 'id' => $missionCall->id],
                ["class" => ""]
            ) ?>
            <?= Html::a(
                Glyphicon::trash(),
                ['mission-call/confirm-delete', 'id' => $missionCall->id],
                ["class" => "ajax-dialog", "data-size" => "sm"]
            ) ?>
        </td>
    </tr>
<?php endforeach; ?>