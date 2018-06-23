<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $modelName string */
/* @var $exclude array */
/* @var $checked bool */

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
if($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}

$checked = !isset($checked) ? false : $checked;
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : null ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : null ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : null ?>">
<?php /** @var $staff \app\models\Staff */ ?>
<?php foreach ($dataProvider->getModels() as $staff): ?>
    <tr data-key="<?= $staff->rpn ?>">
        <?php if (!in_array("rpn", $exclude)): ?>
            <td class="rpn">
                <?= $staff->rpn ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $staff->name ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("team", $exclude)): ?>
            <td class="team">
                <?= $staff->team_id ? $staff->team->name : null ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("callsign", $exclude)): ?>
            <td class="callsign">
                <?= $staff->callsign ?>
            </td>
        <?php endif; ?>
        <td class="actions">
            <?= Glyphicon::arrow_right(["class" => "list-btn add-row"]) ?>
            <?= Glyphicon::remove(["class" => "assigned-btn remove-row"]) ?>
            <?= Html::checkbox("{$modelName}[staffSelect][]", $checked, [
                "value" => $staff->rpn,
                "class" => " table-form-select-checkbox hidden"
            ]); ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>