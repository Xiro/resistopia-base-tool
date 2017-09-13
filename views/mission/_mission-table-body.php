<?php

/* @var $missionModels \app\models\Mission[] */

use yii\helpers\Html;
use app\widgets\Glyphicon;
?>

<?php foreach ($missionModels as $mission): ?>
    <tr>
        <td class="name">
            <?= $mission->name ?>
        </td>
        <td class="mission-status">
            <?= $mission->missionStatus ? $mission->missionStatus->name : "None" ?>
        </td>
        <td class="mission-type">
            <?= $mission->missionType ? $mission->missionType->name : "None" ?>
        </td>
        <td class="zone">
            <?= $mission->zone ?>
        </td>
        <td class="description">
            <?= $mission->getCutDescription() ?>
        </td>
        <td class="debrief-comment">
            <?= $mission->getCutDebriefComment() ?>
        </td>
        <td class="rp">
            <?= $mission->RP ?>
        </td>
        <td class="fp">
            <?= $mission->FP ?>
        </td>
        <td class="started">
            <?= $mission->started ? date("H:i d.m.", strtotime($mission->started)) : "" ?>
        </td>
        <td class="ended">
            <?= $mission->ended ? date("H:i d.m.", strtotime($mission->ended)) : "" ?>
        </td>
        <td class="actions">
            <?= Html::a(
                Glyphicon::pencil(),
                ['mission/update', 'id' => $mission->id],
                ["class" => "ajax-dialog"]
            ) ?>
            <?= Html::a(
                Glyphicon::trash(),
                ['mission/confirm-delete', 'id' => $mission->id],
                ["class" => "ajax-dialog"]
            ) ?>
        </td>
    </tr>
<?php endforeach; ?>