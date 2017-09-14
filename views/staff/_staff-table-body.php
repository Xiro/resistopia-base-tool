<?php

use yii\helpers\Html;
use app\widgets\Glyphicon;

/* @var $staffModels \app\models\Staff[] */
/* @var $exclude array */

$exclude = !isset($exclude) ? array() : $exclude;
?>

<?php foreach ($staffModels as $staff): ?>
    <tr>
        <?php if (!in_array("rpn", $exclude)): ?>
            <td class="rpn">
                <?= $staff->rpn ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $staff->getName() ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("category", $exclude)): ?>
            <td class="category">
                <span><?= $staff->category ? $staff->category->name : "None" ?></span>
            </td>
        <?php endif; ?>
        <?php if (!in_array("speciality", $exclude)): ?>
            <td class="speciality">
                <?= $staff->speciality ? $staff->speciality->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("team", $exclude)): ?>
            <td class="team">
                <?= $staff->team ? $staff->team->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("staff-status", $exclude)): ?>
            <td class="staff-status">
                <?= $staff->staffStatus ? $staff->staffStatus->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("call-sign", $exclude)): ?>
            <td class="call-sign">
                <?= $staff->call_sign ? $staff->call_sign : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['staff/update', 'id' => $staff->id],
                        ["class" => ""]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['staff/confirm-delete', 'id' => $staff->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>