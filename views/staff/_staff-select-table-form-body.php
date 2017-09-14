<?php

/* @var $staffModels \app\models\Staff[] */
/* @var $modelName string */
/* @var $exclude array */
/* @var $checked bool */

$checked = !isset($checked) ? false : $checked;
$exclude = !isset($exclude) ? array() : $exclude;
use app\widgets\Glyphicon;
use yii\helpers\Html;

?>

<?php foreach ($staffModels as $staff): ?>
    <tr data-id="<?= $staff->id ?>">
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
        <?php if (!in_array("team", $exclude)): ?>
            <td class="team">
                <?= $staff->team ? $staff->team->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("call-sign", $exclude)): ?>
            <td class="call-sign">
                <?= $staff->call_sign ? $staff->call_sign : "None" ?>
            </td>
        <?php endif; ?>
        <td class="actions">
            <?= Glyphicon::arrow_right(["class" => "list-btn add-staff"]) ?>
            <?= Glyphicon::remove(["class" => "assigned-btn remove-staff"]) ?>
            <?= Html::checkbox("{$modelName}[staffSelect][]", $checked, [
                "value" => $staff->id,
                "class" => " staff-select-checkbox hidden"
            ]); ?>
        </td>
    </tr>
<?php endforeach; ?>