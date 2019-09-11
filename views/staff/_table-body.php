<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $exclude array */
/* @var $mergeExclude boolean */

use app\helpers\Html;
use app\models\Staff;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
if ($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}
$mergeExclude = !isset($mergeExclude) ? true : $mergeExclude;
if (isset($exclude) && $mergeExclude) {
    $exclude = array_merge(Staff::$defaultTableExclude, $exclude);
} elseif (!isset($exclude)) {
    $exclude = Staff::$defaultTableExclude;
}
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
        <?php if (!in_array("gender", $exclude)): ?>
            <td class="gender">
                <?php
                switch ($model->gender) {
                    case "m": echo "Male";break;
                    case "f": echo "Female";break;
                    default: echo "";
                }
                ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("date_of_birth", $exclude)): ?>
            <td class="date_of_birth">
                <?= $model->date_of_birth ? date("d.m.Y", strtotime($model->date_of_birth)) : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("height", $exclude)): ?>
            <td class="height">
                <?= $model->height ? $model->height . " cm" : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("eye_color", $exclude)): ?>
            <td class="eye_color">
                <?= $model->eye_color_id ? $model->eyeColor->name : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("profession", $exclude)): ?>
            <td class="profession">
                <?= $model->profession ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("blood_type", $exclude)): ?>
            <td class="blood_type">
                <?= $model->blood_type_id ? $model->bloodType->name : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("team", $exclude)): ?>
            <td class="team">
                <?= $model->team_id ? $model->team->name : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("special_function", $exclude)): ?>
            <td class="special_function">
                <?= $model->special_function_id ? $model->specialFunction->name : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("section", $exclude)): ?>
            <td class="section">
                <?= $model->section_id ? $model->section->section : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("department", $exclude)): ?>
            <td class="department">
                <?= $model->section_id ? $model->section->department : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("citizenship", $exclude)): ?>
            <td class="citizenship">
                <?= $model->citizenship_id ? $model->citizenship->name : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("rank", $exclude)): ?>
            <td class="rank">
                <?= $model->rank_id ? $model->rank->short_name : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("registered", $exclude)): ?>
            <td class="registered">
                <?= $model->registered ? date("d.m.Y", strtotime($model->registered)) : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("resistance_cell", $exclude)): ?>
            <td class="resistance_cell">
                <?= $model->resistance_cell_id ? $model->resistanceCell->name : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("callsign", $exclude)): ?>
            <td class="callsign">
                <?= $model->callsign ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("status_alive", $exclude)): ?>
            <td class="">
                <?= $model->status_alive == "1" ? "Yes" : "No" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("created", $exclude)): ?>
            <td class="created">
                <?= $model->created ? date("d.m.Y H:i", strtotime($model->created)) : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("updated", $exclude)): ?>
            <td class="updated">
                <?= $model->updated ? date("d.m.Y H:i", strtotime($model->updated)) : "" ?>
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