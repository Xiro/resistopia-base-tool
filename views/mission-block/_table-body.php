<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $exclude array */

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
if($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : 0 ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : 0 ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : 0 ?>">
<?php /** @var $model \app\models\MissionBlock */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("blocked_staff_member", $exclude)): ?>
            <td class="blocked_staff_member">
                <?= $model->blocked_staff_member_rpn ? $model->blockedStaffMember->nameWithRpn : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("unblock_time", $exclude)): ?>
            <td class="unblock_time">
                <?= $model->unblock_time ? date('d.m.Y H:i', strtotime($model->created)) : 'Unlimited' ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("blocked_by", $exclude)): ?>
            <td class="blocked_by">
                <?= $model->blocked_by_rpn ? $model->blockedBy->nameWithRpn . ' ' . Html::a(
                        Glyphicon::eye_open(),
                        ['staff/view', 'id' => $model->blocked_by_rpn],
                        ["class" => "ajax-dialog"]
                    ) : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("created", $exclude)): ?>
            <td class="created">
                <?= date('d.m.Y H:i', strtotime($model->created)) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['mission-block/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['mission-block/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>