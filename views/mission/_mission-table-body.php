<?php

use yii\helpers\Html;
use app\widgets\Glyphicon;

/* @var $missionModels \app\models\Mission[] */
/* @var $exclude array */

$exclude = !isset($exclude) ? array() : $exclude;
?>

<?php foreach ($missionModels as $mission): ?>
    <tr>
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $mission->name ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("mission-status", $exclude)): ?>
            <td class="mission-status">
                <?= $mission->missionStatus ? $mission->missionStatus->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("mission-type", $exclude)): ?>
            <td class="mission-type">
                <?= $mission->missionType ? $mission->missionType->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("zone", $exclude)): ?>
            <td class="zone">
                <?= $mission->zone ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("description", $exclude)): ?>
            <td class="description">
                <?= $mission->getCutDescription() ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("debrief-comment", $exclude)): ?>
            <td class="debrief-comment">
                <?= $mission->getCutDebriefComment() ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("rp", $exclude)): ?>
            <td class="rp">
                <?= $mission->RP ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("fp", $exclude)): ?>
            <td class="fp">
                <?= $mission->FP ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("started", $exclude)): ?>
            <td class="started">
                <?= $mission->started ? date("H:i d.m.", strtotime($mission->started)) : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("ended", $exclude)): ?>
            <td class="ended">
                <?= $mission->ended ? date("H:i d.m.", strtotime($mission->ended)) : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("call-sign", $exclude)): ?>
            <td class="call-sign">
                <?= implode(", ", $mission->getCallSigns()) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['mission/update', 'id' => $mission->id],
                        ["class" => ""]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['mission/confirm-delete', 'id' => $mission->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>