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
<?php /** @var $model \app\models\Staff */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->rpn ?>">
        <?php if (!in_array("rpn", $exclude)): ?>
            <td class="rpn">
                <?= $model->rpn ?>
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
        <?php if (!in_array("base_category", $exclude)): ?>
            <td class="base_category">
                <?= $model->base_category_id ? $model->baseCategory->name : null ?>
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
        <?php if (!in_array("status_in_base", $exclude)): ?>
            <td class="status_in_base">
                <?= $model->status_in_base ? 'Yes' : 'No' ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['staff/view', 'id' => $model->rpn],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['staff/update', 'id' => $model->rpn]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-grant-rights", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::lock(),
                        ['staff/grant-rights', 'id' => $model->rpn]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-add-file-memo", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::file(),
                        ['staff-file-memo/create', 'id' => $model->rpn]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['staff/confirm-delete', 'id' => $model->rpn],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>