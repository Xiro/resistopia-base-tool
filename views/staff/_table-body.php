<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $exclude array */

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
if ($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : 0 ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : 0 ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : 0 ?>">
<?php /** @var $model \app\models\Staff */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->sid ?>">
        <?php if (!in_array("sid", $exclude)): ?>
            <td class="sid">
                <?= $model->sid ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $model->name ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("team", $exclude)): ?>
            <td class="team">
                <?= $model->team_id ? $model->team->name : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("rank", $exclude)): ?>
            <td class="rank">
                <?= $model->rank_id ? $model->rank->short_name : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("section", $exclude)): ?>
            <td class="section">
                <?= $model->section_id ? $model->section->department : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("special_function", $exclude)): ?>
            <td class="special_function">
                <?= $model->special_function_id ? $model->specialFunction->name : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("callsign", $exclude)): ?>
            <td class="callsign">
                <?= $model->callsign ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['staff/view', 'id' => $model->sid],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['staff/update', 'id' => $model->sid]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-add-file-memo", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::file(),
                        ['staff-file-memo/create', 'id' => $model->sid],
                        ['title' => 'Add File Memo']
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-grant-rights", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::lock(),
                        ['staff/grant-rights', 'id' => $model->sid],
                        ['title' => 'Grant Rights']
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-mission-block", $exclude)): ?>
                    <?php if ($model->isBlocked): ?>
                        <?= Html::a(
                            Glyphicon::ok_sign(),
                            ['mission-block/lift', 'id' => $model->sid],
                            ['title' => 'Lift Mission Block']
                        ) ?>
                    <?php else: ?>
                        <?= Html::a(
                            Glyphicon::ban_circle(),
                            ['mission-block/create', 'id' => $model->sid],
                            ['title' => 'Add Mission Block']
                        ) ?>
                    <?php endif; ?>

                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['staff/confirm-delete', 'id' => $model->sid],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>