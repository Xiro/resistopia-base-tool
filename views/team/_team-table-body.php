<?php

/* @var $teamModels \app\models\Team[] */
/* @var $exclude array */

use yii\helpers\Html;
use app\widgets\Glyphicon;

$exclude = !isset($exclude) ? array() : $exclude;
?>

<?php foreach ($teamModels as $team): ?>
    <tr>
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $team->name ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("paid", $exclude)): ?>
            <td class="paid">
                <?= $team->getPaidRP() . " RP" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("unpaid", $exclude)): ?>
            <td class="unpaid">
                <?= $team->getUnpaidRP() . " RP" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("members", $exclude)): ?>
            <td class="members">
                <?= $team->getStaff()->count() ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['team/view', 'id' => $team->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['team/update', 'id' => $team->id],
                        ["class" => ""]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['team/confirm-delete', 'id' => $team->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>