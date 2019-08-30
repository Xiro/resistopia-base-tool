<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $modelName string */
/* @var $exclude array */
/* @var $checked bool */

/* @var $actionEnableValidators array */

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
if ($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}

$actionEnableValidators = !isset($actionEnableValidators) ? [] : $actionEnableValidators;
$checked = !isset($checked) ? false : $checked;
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : null ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : null ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : null ?>">
<?php /** @var $staff \app\models\Staff */ ?>
<?php foreach ($dataProvider->getModels() as $staff): ?>
    <tr data-key="<?= $staff->sid ?>">
        <?php if (!in_array("rpn", $exclude)): ?>
            <td class="rpn">
                <?= $staff->sid ?>
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
        <td class="actions">
            <?php if (!in_array("action-view", $exclude)): ?>
                <?= Html::a(
                    Glyphicon::eye_open(),
                    ['staff/view', 'id' => $staff->sid],
                    ["class" => "ajax-dialog", "data-size" => "lg"]
                ) ?>
            <?php endif; ?>
            <?php
            foreach ($actionEnableValidators as $validator) {
                if (!is_callable($validator)) {
                    continue;
                }
                $validation = $validator($staff);
                if ($validation === true) {
                    continue;
                }
                $validationMessage = $validation;
                break;
            }
            ?>
            <?php if (isset($validationMessage)): ?>
                <?= $validationMessage ?>
            <?php else: ?>
                <?= Glyphicon::arrow_right(["class" => "list-btn add-row"]) ?>
            <?php endif; ?>
            <?= Glyphicon::remove(["class" => "assigned-btn remove-row"]) ?>
            <?= Html::checkbox("{$modelName}[staffSelect][]", $checked, [
                "value" => $staff->sid,
                "class" => " table-form-select-checkbox hidden"
            ]); ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>